<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * RDAP domain lookups for the Domain Age Checker. RDAP (RFC 7480-7484) is the free, keyless
 * successor to WHOIS. rdap.org looks up the authoritative registry for a domain's TLD (from
 * IANA's bootstrap registry) and redirects there; every hop is checked with SafeUrl and pinned
 * with CURLOPT_RESOLVE, exactly like the Broken Link Checker. Results are cached for a day,
 * since registration data rarely changes.
 */
class Rdap
{
    private const ENTRY_URL = 'https://rdap.org/domain/';

    private const MAX_REDIRECTS = 5;

    private const CACHE_HOURS = 24;

    private const USER_AGENT = 'Mozilla/5.0 (compatible; ILoveMyToolsDomainAge/1.0; +https://ilovemytools.store/domain-age-checker)';

    public function __construct(private SafeUrl $guard)
    {
    }

    /** "https://www.Example.COM/page" -> "example.com"; null when it isn't a domain. */
    public static function normalize(string $input): ?string
    {
        return OpenPageRank::normalize($input);
    }

    /**
     * @return array{created: ?string, expires: ?string, updated: ?string, registrar: ?string, status: list<string>, nameservers: list<string>}|array{error: string}
     */
    public function lookup(string $domain): array
    {
        $key = "rdap:$domain";
        $cached = Cache::get($key);
        if ($cached !== null) {
            return $cached;
        }

        $result = $this->fetch(self::ENTRY_URL.$domain, self::parse(...));
        // Cache stable outcomes (a record, or a confirmed miss); not transient failures, so a
        // visitor can simply try again instead of being stuck with "unavailable" for a day.
        if (! isset($result['error']) || in_array($result['error'], ['not-found', 'tld-not-supported'], true)) {
            Cache::put($key, $result, now()->addHours(self::CACHE_HOURS));
        }

        return $result;
    }

    /**
     * Owner of the network an IP address belongs to (the hosting company), from the regional
     * internet registry's RDAP record. Cached for a day like domains.
     *
     * @return array{network: ?string, handle: ?string, country: ?string}|array{error: string}
     */
    public function network(string $ip): array
    {
        if (! SafeUrl::isPublicIp($ip)) {
            return ['error' => 'not-found'];
        }

        $cached = Cache::get("rdap-ip:$ip");
        if ($cached !== null) {
            return $cached;
        }
        $result = $this->fetch('https://rdap.org/ip/'.$ip, self::parseNetwork(...));
        if (! isset($result['error'])) {
            Cache::put("rdap-ip:$ip", $result, now()->addHours(self::CACHE_HOURS));
        }

        return $result;
    }

    /**
     * @param  callable(array): array  $parse
     * @return array<string, mixed>
     */
    private function fetch(string $url, callable $parse): array
    {
        $redirected = false;

        for ($hop = 0; $hop <= self::MAX_REDIRECTS; $hop++) {
            $target = $this->guard->check($url);
            if (is_string($target)) {
                return ['error' => 'unavailable'];
            }

            try {
                $res = Http::withOptions($this->options($target))
                    ->withHeaders(['User-Agent' => self::USER_AGENT, 'Accept' => 'application/rdap+json, application/json'])
                    ->get($url);
            } catch (Throwable) {
                return ['error' => 'unavailable'];
            }

            if ($res->redirect() && $res->header('Location')) {
                $next = LinkChecker::resolve($res->header('Location'), $url);
                if ($next === null) {
                    return ['error' => 'unavailable'];
                }
                $url = $next;
                $redirected = true;

                continue;
            }
            if ($res->successful()) {
                $json = $res->json();

                return is_array($json) ? $parse($json) : ['error' => 'unavailable'];
            }
            if ($res->status() === 404) {
                // A 404 straight from rdap.org (never redirected) means it found no RDAP
                // server for this TLD; a 404 from the registry it redirected to means the
                // domain itself has no record (unregistered, or not yet in the registry).
                return ['error' => $redirected ? 'not-found' : 'tld-not-supported'];
            }

            return ['error' => 'unavailable'];
        }

        return ['error' => 'unavailable'];
    }

    /**
     * Guzzle options that connect to the already-validated IP (no second DNS lookup).
     * Never set 'stream': Guzzle then switches to PHP streams, which ignore CURLOPT_RESOLVE.
     */
    private function options(array $target): array
    {
        $ip = str_contains($target['ip'], ':') ? '['.$target['ip'].']' : $target['ip'];

        return [
            'allow_redirects' => false,
            'timeout' => 10,
            'connect_timeout' => 5,
            'http_errors' => false,
            'curl' => [
                CURLOPT_RESOLVE => ["{$target['host']}:{$target['port']}:{$ip}"],
                CURLOPT_MAXFILESIZE => 1_000_000,
            ],
        ];
    }

    /** @return array{network: ?string, handle: ?string, country: ?string} */
    private static function parseNetwork(array $json): array
    {
        $owner = null;
        foreach ((array) ($json['entities'] ?? []) as $entity) {
            if (! in_array('registrant', (array) ($entity['roles'] ?? []), true)) {
                continue;
            }
            foreach ((array) ($entity['vcardArray'][1] ?? []) as $property) {
                if (($property[0] ?? '') === 'fn' && ! empty($property[3])) {
                    $owner = (string) $property[3];
                    break 2;
                }
            }
        }

        return [
            'network' => $owner ?? (isset($json['name']) ? (string) $json['name'] : null),
            'handle' => isset($json['name']) ? (string) $json['name'] : null,
            'country' => isset($json['country']) && preg_match('/^[A-Z]{2}$/', (string) $json['country']) ? (string) $json['country'] : null,
        ];
    }

    /** @return array{created: ?string, expires: ?string, updated: ?string, registrar: ?string, status: list<string>, nameservers: list<string>} */
    private static function parse(array $json): array
    {
        $events = [];
        foreach ((array) ($json['events'] ?? []) as $event) {
            if (! empty($event['eventAction'])) {
                $events[$event['eventAction']] = $event['eventDate'] ?? null;
            }
        }

        $registrar = null;
        foreach ((array) ($json['entities'] ?? []) as $entity) {
            if (! in_array('registrar', (array) ($entity['roles'] ?? []), true)) {
                continue;
            }
            foreach ((array) ($entity['vcardArray'][1] ?? []) as $property) {
                if (($property[0] ?? '') === 'fn' && ! empty($property[3])) {
                    $registrar = (string) $property[3];
                    break 2;
                }
            }
            $registrar = $entity['handle'] ?? null;
            break;
        }

        $nameservers = [];
        foreach ((array) ($json['nameservers'] ?? []) as $ns) {
            if (! empty($ns['ldhName'])) {
                $nameservers[] = strtolower((string) $ns['ldhName']);
            }
        }

        return [
            'created' => $events['registration'] ?? null,
            'expires' => $events['expiration'] ?? null,
            'updated' => $events['last changed'] ?? null,
            'registrar' => $registrar,
            'status' => array_values((array) ($json['status'] ?? [])),
            'nameservers' => $nameservers,
        ];
    }
}

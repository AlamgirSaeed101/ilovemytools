<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Facades\Cache;
use Throwable;

/**
 * Everything public about one domain for the Domain Authority Checker's "Details" panel:
 * registration (RDAP), DNS (A/AAAA, NS, MX), the hosting network behind its IP (Team Cymru's
 * free IP-to-ASN DNS service), HTTPS certificate and OpenPageRank score. All keyless; cached
 * for six hours. Only public IPs are ever connected to (same rule as the link checker).
 */
class DomainInfo
{
    private const CACHE_HOURS = 6;

    /** Hostname fragments of well-known DNS hosts, checked against the NS records. */
    private const DNS_HOSTS = [
        'cloudflare.com' => 'Cloudflare',
        'awsdns' => 'Amazon Route 53',
        'googledomains.com' => 'Google Cloud DNS',
        'ns-cloud' => 'Google Cloud DNS',
        'azure-dns' => 'Microsoft Azure DNS',
        'domaincontrol.com' => 'GoDaddy',
        'registrar-servers.com' => 'Namecheap',
        'digitalocean.com' => 'DigitalOcean',
        'hostinger' => 'Hostinger',
        'bluehost.com' => 'Bluehost',
        'hostgator.com' => 'HostGator',
        'wixdns.net' => 'Wix',
        'squarespacedns.com' => 'Squarespace',
        'shopify.com' => 'Shopify',
        'vercel-dns.com' => 'Vercel',
        'nsone.net' => 'NS1',
        'dnsmadeeasy.com' => 'DNS Made Easy',
        'ultradns' => 'UltraDNS',
        'akam.net' => 'Akamai',
        'sucuridns.com' => 'Sucuri',
        'ovh.net' => 'OVHcloud',
        'hetzner' => 'Hetzner',
        'name.com' => 'Name.com',
        'porkbun.com' => 'Porkbun',
        'dynect.net' => 'Oracle Dyn',
    ];

    /** Hostname fragments of well-known email providers, checked against the MX records. */
    private const MAIL_HOSTS = [
        'google.com' => 'Google Workspace',
        'googlemail.com' => 'Google Workspace',
        'outlook.com' => 'Microsoft 365',
        'zoho' => 'Zoho Mail',
        'protonmail' => 'Proton Mail',
        'icloud.com' => 'iCloud Mail',
        'yahoodns.net' => 'Yahoo Mail',
        'secureserver.net' => 'GoDaddy Email',
        'mimecast' => 'Mimecast',
        'pphosted.com' => 'Proofpoint',
        'messagingengine.com' => 'Fastmail',
        'mailgun.org' => 'Mailgun',
        'amazonaws.com' => 'Amazon SES',
        'yandex' => 'Yandex Mail',
        'titan.email' => 'Titan Mail',
    ];

    /**
     * @param  (Closure(string, int): list<array<string, mixed>>)|null  $dns  host, DNS_* type -> records
     * @param  (Closure(string, string): ?array<string, mixed>)|null  $tls  domain, ip -> certificate summary
     */
    public function __construct(
        private Rdap $rdap,
        private OpenPageRank $opr,
        private ?Closure $dns = null,
        private ?Closure $tls = null,
    ) {
        $this->dns ??= static fn (string $host, int $type): array => @dns_get_record($host, $type) ?: [];
        $this->tls ??= self::fetchCertificate(...);
    }

    /** @return array<string, mixed> */
    public function lookup(string $domain): array
    {
        return Cache::remember("domaininfo:$domain", now()->addHours(self::CACHE_HOURS), fn () => $this->build($domain));
    }

    /** @return array<string, mixed> */
    private function build(string $domain): array
    {
        $ipv4 = $this->records($domain, DNS_A, 'ip');
        $ipv6 = $this->records($domain, DNS_AAAA, 'ipv6');
        $ns = $this->records($domain, DNS_NS, 'target');
        $mx = $this->mx($domain);

        $publicIp = null;
        foreach ([...$ipv4, ...$ipv6] as $ip) {
            if (SafeUrl::isPublicIp($ip)) {
                $publicIp = $ip;
                break;
            }
        }

        $registration = $this->rdap->lookup($domain);
        $score = null;
        if ($this->opr->configured()) {
            $result = $this->opr->lookup([$domain]);
            $score = $result['results'][0] ?? null;
        }

        return [
            'domain' => $domain,
            'resolves' => $ipv4 !== [] || $ipv6 !== [],
            'registration' => isset($registration['error']) ? ['error' => $registration['error']] : $registration,
            'dns' => [
                'ipv4' => $ipv4,
                'ipv6' => $ipv6,
                'nameservers' => $ns,
                'dns_provider' => self::match($ns, self::DNS_HOSTS),
                'mx' => $mx,
                'mail_provider' => self::match($mx, self::MAIL_HOSTS),
            ],
            'hosting' => $publicIp === null ? null : $this->hosting($publicIp),
            'https' => $publicIp === null ? null : ($this->tls)($domain, $publicIp),
            'score' => $score,
        ];
    }

    /** @return list<string> */
    private function records(string $host, int $type, string $field): array
    {
        $values = [];
        foreach (($this->dns)($host, $type) as $record) {
            if (! empty($record[$field])) {
                $values[] = strtolower((string) $record[$field]);
            }
        }
        $values = array_values(array_unique($values));
        sort($values);

        return array_slice($values, 0, 8);
    }

    /** @return list<string> mail servers, lowest priority (preferred) first */
    private function mx(string $domain): array
    {
        $records = ($this->dns)($domain, DNS_MX);
        usort($records, fn ($a, $b) => ($a['pri'] ?? 0) <=> ($b['pri'] ?? 0));
        $hosts = [];
        foreach ($records as $record) {
            if (! empty($record['target'])) {
                $hosts[] = strtolower((string) $record['target']);
            }
        }

        return array_slice(array_values(array_unique($hosts)), 0, 5);
    }

    /**
     * Who hosts the IP: the announcing network (ASN) when Team Cymru answers, else the owner of
     * the IP block from the registry's RDAP record. Null when neither knows.
     *
     * @return array{ip: string, asn: ?int, network: ?string, prefix: ?string, country: ?string}|null
     */
    private function hosting(string $ip): ?array
    {
        $asn = str_contains($ip, ':') ? null : $this->network($ip);
        if ($asn !== null && $asn['network'] !== null) {
            return ['ip' => $ip] + $asn;
        }

        $owner = $this->rdap->network($ip);
        if (isset($owner['error']) && $asn === null) {
            return null;
        }

        return [
            'ip' => $ip,
            'asn' => $asn['asn'] ?? null,
            'network' => $owner['network'] ?? null,
            'prefix' => $asn['prefix'] ?? null,
            'country' => $asn['country'] ?? $owner['country'] ?? null,
        ];
    }

    /**
     * Network that announces an IPv4 address, from Team Cymru's IP-to-ASN DNS service:
     * "1.2.3.4" -> TXT 4.3.2.1.origin.asn.cymru.com = "13335 | 1.2.3.0/24 | US | arin | 2010-07-14",
     * then TXT AS13335.asn.cymru.com = "13335 | US | arin | 2010-07-14 | CLOUDFLARENET, US".
     *
     * @return array{asn: int, network: ?string, prefix: ?string, country: ?string}|null
     */
    private function network(string $ip): ?array
    {
        $origin = $this->txt(implode('.', array_reverse(explode('.', $ip))).'.origin.asn.cymru.com');
        if ($origin === null) {
            return null;
        }
        $parts = array_map('trim', explode('|', $origin));
        $asn = (int) strtok($parts[0] ?? '', ' ');
        if ($asn <= 0) {
            return null;
        }

        $name = null;
        $info = $this->txt("AS$asn.asn.cymru.com");
        if ($info !== null) {
            $fields = array_map('trim', explode('|', $info));
            $name = ($fields[4] ?? '') !== '' ? preg_replace('/,\s*[A-Z]{2}$/', '', $fields[4]) : null;
        }

        return [
            'asn' => $asn,
            'network' => $name,
            'prefix' => ($parts[1] ?? '') !== '' ? $parts[1] : null,
            'country' => preg_match('/^[A-Z]{2}$/', $parts[2] ?? '') ? $parts[2] : null,
        ];
    }

    private function txt(string $host): ?string
    {
        foreach (($this->dns)($host, DNS_TXT) as $record) {
            $text = $record['txt'] ?? (isset($record['entries']) ? implode('', (array) $record['entries']) : '');
            if ($text !== '') {
                return (string) $text;
            }
        }

        return null;
    }

    /** First provider whose fragment appears in any of the hostnames. */
    private static function match(array $hosts, array $map): ?string
    {
        foreach ($hosts as $host) {
            foreach ($map as $fragment => $name) {
                if (str_contains($host, $fragment)) {
                    return $name;
                }
            }
        }

        return null;
    }

    /**
     * HTTPS check against the already-resolved public IP, with SNI for the domain.
     *
     * @return array{valid: bool, issuer: ?string, expires: ?string}|null null when nothing answers on port 443
     */
    private static function fetchCertificate(string $domain, string $ip): ?array
    {
        $address = str_contains($ip, ':') ? "[$ip]" : $ip;
        $open = static function (bool $verify) use ($domain, $address) {
            $context = stream_context_create(['ssl' => [
                'capture_peer_cert' => true,
                'peer_name' => $domain,
                'SNI_enabled' => true,
                'verify_peer' => $verify,
                'verify_peer_name' => $verify,
            ]]);
            try {
                $client = @stream_socket_client("ssl://$address:443", $errno, $error, 5, STREAM_CLIENT_CONNECT, $context);
            } catch (Throwable) {
                return null;
            }
            if (! $client) {
                return null;
            }
            $cert = stream_context_get_params($client)['options']['ssl']['peer_certificate'] ?? null;
            fclose($client);

            return $cert ? (openssl_x509_parse($cert) ?: null) : null;
        };

        $valid = true;
        $parsed = $open(true);
        if ($parsed === null) {
            $valid = false;
            $parsed = $open(false);
            if ($parsed === null) {
                return null;
            }
        }

        $issuer = $parsed['issuer']['O'] ?? $parsed['issuer']['CN'] ?? null;

        return [
            'valid' => $valid,
            'issuer' => is_array($issuer) ? implode(', ', $issuer) : $issuer,
            'expires' => isset($parsed['validTo_time_t']) ? gmdate('Y-m-d\TH:i:s\Z', (int) $parsed['validTo_time_t']) : null,
        ];
    }
}

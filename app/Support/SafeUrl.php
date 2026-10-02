<?php

namespace App\Support;

use Closure;

/**
 * Validates URLs the server is asked to fetch (link checker), so it can't be used to reach
 * private networks (SSRF): only http(s) on ports 80/443, and every resolved IP must be public.
 * The caller pins the connection to the returned IP (CURLOPT_RESOLVE) to stop DNS rebinding.
 */
class SafeUrl
{
    /** @param (Closure(string): list<string>)|null $resolver host -> IP addresses */
    public function __construct(private ?Closure $resolver = null)
    {
        $this->resolver ??= static function (string $host): array {
            $ips = gethostbynamel($host) ?: [];
            foreach (@dns_get_record($host, DNS_AAAA) ?: [] as $r) {
                if (! empty($r['ipv6'])) {
                    $ips[] = $r['ipv6'];
                }
            }

            return $ips;
        };
    }

    /** Normalise user input ("example.com/page" -> "https://example.com/page"); null if unusable. */
    public static function normalize(string $input): ?string
    {
        $url = trim($input);
        if ($url === '' || mb_strlen($url) > 2048) {
            return null;
        }
        if (! preg_match('#^[a-z][a-z0-9+.-]*://#i', $url)) {
            $url = 'https://'.$url;
        }
        $parts = parse_url($url);

        return ($parts && in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true) && ! empty($parts['host'])) ? $url : null;
    }

    /**
     * @return array{host: string, port: int, ip: string}|string the address to connect to, or why not:
     *                                                           "not-allowed" (private/unsupported) or "dns" (host not found)
     */
    public function check(string $url): array|string
    {
        $parts = parse_url($url);
        $scheme = strtolower($parts['scheme'] ?? '');
        $host = strtolower(trim((string) ($parts['host'] ?? ''), '[]'));
        if (! in_array($scheme, ['http', 'https'], true) || $host === '' || isset($parts['user']) || isset($parts['pass'])) {
            return 'not-allowed';
        }
        $port = (int) ($parts['port'] ?? ($scheme === 'https' ? 443 : 80));
        if (! in_array($port, [80, 443], true)) {
            return 'not-allowed';
        }
        if ($host === 'localhost' || str_ends_with($host, '.localhost') || str_ends_with($host, '.local') || str_ends_with($host, '.internal')) {
            return 'not-allowed';
        }

        $ips = filter_var($host, FILTER_VALIDATE_IP) ? [$host] : ($this->resolver)($host);
        if ($ips === []) {
            return 'dns';
        }
        foreach ($ips as $ip) {
            if (! self::isPublicIp($ip)) {
                return 'not-allowed'; // one private record is enough to refuse
            }
        }

        return ['host' => $host, 'port' => $port, 'ip' => $ips[0]];
    }

    public static function isPublicIp(string $ip): bool
    {
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return false;
        }
        // Ranges PHP's flags don't cover: carrier-grade NAT, benchmarking, IPv6 unique-local/link-local, IPv4-mapped IPv6.
        foreach (['100.64.0.0/10', '198.18.0.0/15', '192.0.0.0/24'] as $cidr) {
            if (self::inCidr4($ip, $cidr)) {
                return false;
            }
        }
        $lower = strtolower($ip);

        return ! (str_starts_with($lower, 'fc') || str_starts_with($lower, 'fd') || str_starts_with($lower, 'fe80') || str_starts_with($lower, '::ffff:'));
    }

    private static function inCidr4(string $ip, string $cidr): bool
    {
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }
        [$base, $bits] = explode('/', $cidr);
        $mask = -1 << (32 - (int) $bits);

        return (ip2long($ip) & $mask) === (ip2long($base) & $mask);
    }
}

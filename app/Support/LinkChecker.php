<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

/**
 * Fetches a page and checks its links for the Broken Link Checker.
 * Every request (and every redirect hop) goes through SafeUrl and is pinned to the checked IP.
 */
class LinkChecker
{
    public const MAX_LINKS = 300;

    public const MAX_PAGE_BYTES = 3_000_000;

    private const MAX_REDIRECTS = 5;

    private const USER_AGENT = 'Mozilla/5.0 (compatible; ILoveMyToolsLinkChecker/1.0; +https://ilovemytools.store/broken-link-checker)';

    public function __construct(private SafeUrl $guard)
    {
    }

    /**
     * Guzzle options that connect to the already-validated IP (no second DNS lookup).
     * Never set 'stream': Guzzle then switches to PHP streams, which ignore CURLOPT_RESOLVE.
     */
    private function options(array $target, int $timeout, ?callable $onHeaders = null): array
    {
        $ip = str_contains($target['ip'], ':') ? '['.$target['ip'].']' : $target['ip'];

        return array_filter([
            'allow_redirects' => false,
            'timeout' => $timeout,
            'connect_timeout' => 5,
            'http_errors' => false,
            'on_headers' => $onHeaders,
            'curl' => [
                CURLOPT_RESOLVE => ["{$target['host']}:{$target['port']}:{$ip}"],
                CURLOPT_MAXFILESIZE => 5_000_000,
            ],
        ], fn ($v) => $v !== null);
    }

    /**
     * Download a page's HTML (following safe redirects) and list its links.
     *
     * @return array{url: string, links: list<array{url: string, text: string, type: string, internal: bool}>, truncated: bool}|array{error: string}
     */
    public function extract(string $url): array
    {
        $current = $url;
        for ($hop = 0; $hop <= self::MAX_REDIRECTS; $hop++) {
            $target = $this->guard->check($current);
            if (is_string($target)) {
                return ['error' => $target];
            }
            try {
                $res = Http::withOptions($this->options($target, 15))
                    ->withHeaders(['User-Agent' => self::USER_AGENT, 'Accept' => 'text/html,application/xhtml+xml'])
                    ->get($current);
            } catch (Throwable) {
                return ['error' => 'unreachable'];
            }
            if ($res->redirect() && $res->header('Location')) {
                $current = self::resolve($res->header('Location'), $current) ?? '';

                continue;
            }
            if (! $res->successful()) {
                return ['error' => 'status', 'status' => $res->status()];
            }
            if (! str_contains(strtolower($res->header('Content-Type')), 'html')) {
                return ['error' => 'not-html'];
            }
            return ['url' => $current] + $this->linksIn(substr($res->body(), 0, self::MAX_PAGE_BYTES), $current);
        }

        return ['error' => 'too-many-redirects'];
    }

    /** @return array{links: list<array{url: string, text: string, type: string, internal: bool}>, truncated: bool} */
    public function linksIn(string $html, string $pageUrl): array
    {
        $doc = new DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NOWARNING | LIBXML_NOERROR);
        libxml_clear_errors();

        $base = $pageUrl;
        foreach ($doc->getElementsByTagName('base') as $el) {
            $base = self::resolve($el->getAttribute('href'), $pageUrl) ?? $pageUrl;
            break;
        }
        $pageHost = strtolower((string) parse_url($pageUrl, PHP_URL_HOST));

        $links = [];
        $add = function (DOMElement $el, string $attr, string $type, string $text) use (&$links, $base, $pageHost) {
            $raw = trim($el->getAttribute($attr));
            if ($raw === '' || preg_match('~^(mailto:|tel:|javascript:|data:|sms:|#)~i', $raw)) {
                return;
            }
            $url = self::resolve($raw, $base);
            if ($url === null || isset($links[$url])) {
                return;
            }
            $links[$url] = [
                'url' => $url,
                'text' => mb_substr(trim(preg_replace('/\s+/u', ' ', $text)), 0, 80),
                'type' => $type,
                'internal' => strtolower((string) parse_url($url, PHP_URL_HOST)) === $pageHost,
            ];
        };
        foreach ($doc->getElementsByTagName('a') as $a) {
            $add($a, 'href', 'link', $a->textContent ?: $a->getAttribute('title'));
        }
        foreach ($doc->getElementsByTagName('img') as $img) {
            $add($img, 'src', 'image', $img->getAttribute('alt'));
        }

        return ['links' => array_slice(array_values($links), 0, self::MAX_LINKS), 'truncated' => count($links) > self::MAX_LINKS];
    }

    /**
     * Check up to 20 URLs concurrently. Only the status line and headers are read: the
     * transfer is aborted before the body (HEAD first, then GET when HEAD isn't supported).
     *
     * @param  list<string>  $urls
     * @return list<array{url: string, status: int|null, final: string, redirects: int, error: string|null}>
     */
    public function check(array $urls): array
    {
        $state = [];
        foreach ($urls as $i => $url) {
            $state[$i] = ['url' => $url, 'current' => $url, 'status' => null, 'redirects' => 0, 'error' => null, 'done' => false, 'method' => 'HEAD'];
        }

        for ($round = 0; $round <= self::MAX_REDIRECTS + 2; $round++) {
            $targets = [];
            foreach ($state as $i => $s) {
                if ($s['done']) {
                    continue;
                }
                $target = $this->guard->check($s['current']);
                if (is_string($target)) {
                    $state[$i] = ['error' => $target, 'done' => true] + $state[$i];

                    continue;
                }
                $targets[$i] = $target;
            }
            if ($targets === []) {
                break;
            }

            $heads = [];
            $responses = Http::pool(function (Pool $pool) use ($targets, $state, &$heads) {
                $requests = [];
                foreach ($targets as $i => $target) {
                    $onHeaders = function ($response) use (&$heads, $i) {
                        $heads[$i] = [$response->getStatusCode(), $response->getHeaderLine('Location')];
                        throw new RuntimeException('headers only'); // stop before the body
                    };
                    $requests[] = $pool->as((string) $i)
                        ->withOptions($this->options($target, 8, $onHeaders))
                        ->withHeaders(['User-Agent' => self::USER_AGENT, 'Accept' => '*/*'])
                        ->send($state[$i]['method'], $state[$i]['current']);
                }

                return $requests;
            });

            foreach ($targets as $i => $_) {
                $res = $responses[(string) $i] ?? null;
                if (! isset($heads[$i]) && $res instanceof Response) {
                    $heads[$i] = [$res->status(), $res->header('Location')]; // full response (e.g. faked in tests)
                }
                if (! isset($heads[$i])) {
                    // No answer (timeout, refused, TLS error). Some servers drop HEAD: try GET once.
                    if ($state[$i]['method'] === 'HEAD') {
                        $state[$i]['method'] = 'GET';
                    } else {
                        $state[$i] = ['error' => 'unreachable', 'done' => true] + $state[$i];
                    }

                    continue;
                }
                [$status, $location] = $heads[$i];
                if ($status >= 300 && $status < 400 && $location !== '') {
                    $next = self::resolve($location, $state[$i]['current']);
                    if ($next === null || $state[$i]['redirects'] >= self::MAX_REDIRECTS) {
                        $state[$i] = ['status' => $status, 'error' => 'too-many-redirects', 'done' => true] + $state[$i];
                    } else {
                        $state[$i]['current'] = $next;
                        $state[$i]['redirects']++;
                    }

                    continue;
                }
                if ($state[$i]['method'] === 'HEAD' && $status >= 400) {
                    $state[$i]['method'] = 'GET'; // many servers answer HEAD wrongly; confirm with GET

                    continue;
                }
                $state[$i] = ['status' => $status, 'done' => true] + $state[$i];
            }
        }

        return array_values(array_map(fn ($s) => [
            'url' => $s['url'],
            'status' => $s['status'],
            'final' => $s['current'],
            'redirects' => $s['redirects'],
            'error' => $s['error'] ?? ($s['done'] ? null : 'unreachable'),
        ], $state));
    }

    /** Resolve a (possibly relative) URL against a base; drops #fragments. Null if not http(s). */
    public static function resolve(string $href, string $base): ?string
    {
        $href = trim(html_entity_decode($href));
        $href = preg_replace('/#.*$/', '', $href);
        if ($href === '') {
            return null;
        }
        if (preg_match('#^//#', $href)) {
            $href = (parse_url($base, PHP_URL_SCHEME) ?: 'https').':'.$href;
        }
        if (preg_match('#^[a-z][a-z0-9+.-]*:#i', $href)) {
            return preg_match('#^https?://#i', $href) ? $href : null;
        }
        $b = parse_url($base);
        if (! $b || empty($b['host'])) {
            return null;
        }
        $origin = $b['scheme'].'://'.$b['host'].(isset($b['port']) ? ':'.$b['port'] : '');
        if (str_starts_with($href, '?')) {
            return $origin.($b['path'] ?? '/').$href;
        }
        $path = str_starts_with($href, '/') ? $href : preg_replace('#/[^/]*$#', '/', $b['path'] ?? '/').$href;
        // Remove ./ and ../ segments.
        $out = [];
        $query = '';
        if (($q = strpos($path, '?')) !== false) {
            $query = substr($path, $q);
            $path = substr($path, 0, $q);
        }
        foreach (explode('/', $path) as $seg) {
            if ($seg === '..') {
                array_pop($out);
            } elseif ($seg !== '.') {
                $out[] = $seg;
            }
        }
        $path = implode('/', $out);

        return $origin.(str_starts_with($path, '/') ? $path : '/'.$path).$query;
    }
}

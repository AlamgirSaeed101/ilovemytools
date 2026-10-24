<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Serves each public HTML page from a saved copy instead of rebuilding it.
 *
 * Building a page takes about 1.2 s on the shared host, and the firewall's cache often misses
 * (different edges, and every deploy purges it), so visitors and Google's speed tests paid that
 * on every miss. Pages are the same for everyone (no sessions, cookies or CSRF tokens), so the
 * first render is saved and reused until the next deploy, whose `optimize:clear` empties the
 * cache and whose warm-cache step fills it again. Production only, so tests always render fresh.
 */
class PageCache
{
    private const HEADERS = ['Content-Type', 'Content-Language', 'Cache-Control', 'Link'];

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->cacheable($request)) {
            return $next($request);
        }

        $key = 'page:'.sha1($request->getSchemeAndHttpHost().$request->getPathInfo());

        if (is_array($hit = Cache::get($key))) {
            $response = new Response(gzuncompress($hit['body']), 200, $hit['headers']);
            $response->headers->set('X-Page-Cache', 'HIT');

            return $response;
        }

        $response = $next($request);

        if ($response->getStatusCode() === 200 && str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            $headers = [];
            foreach (self::HEADERS as $name) {
                if ($response->headers->has($name)) {
                    $headers[$name] = $response->headers->get($name);
                }
            }
            // Stored compressed (~45 KB instead of ~230 KB a page) to keep the shared host's disk use low.
            Cache::forever($key, ['body' => gzcompress((string) $response->getContent(), 6), 'headers' => $headers]);
            $response->headers->set('X-Page-Cache', 'MISS');
        }

        return $response;
    }

    private function cacheable(Request $request): bool
    {
        return app()->environment('production')
            && $request->isMethod('GET')
            && $request->getQueryString() === null
            && ! $request->is('api/*', 'up');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * /index.php and /index.php/merge-pdf would otherwise serve the same pages as / and /merge-pdf
 * (duplicate URLs). Send them, with any query string, to the clean address with one 301.
 * public/.htaccess does the same on Apache; this covers every other server.
 */
class RedirectIndexPhp
{
    public function handle(Request $request, Closure $next): Response
    {
        if (str_ends_with($request->getBaseUrl(), '/index.php') || preg_match('#^/index\.php(/|$)#', $request->getRequestUri())) {
            $path = preg_replace('#^/index\.php#', '', (string) parse_url($request->getRequestUri(), PHP_URL_PATH));
            $path = '/'.ltrim($path, '/');
            $query = $request->getQueryString();

            return redirect()->to($path.($query ? '?'.$query : ''), 301);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Support\Locale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sets the app language. Page routes pass it as a parameter (locale:es);
 * API requests pass ?locale=es.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next, ?string $locale = null): Response
    {
        $locale ??= (string) $request->query('locale', '');
        app()->setLocale(Locale::isSupported($locale) ? $locale : Locale::default());

        $response = $next($request);
        $response->headers->set('Content-Language', Locale::current());

        return $response;
    }
}

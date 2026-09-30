<?php

use App\Support\Locale;

if (! function_exists('t')) {
    /** Translate interface text in Blade views: {{ t('Features') }} */
    function t(string $key, array $vars = []): string
    {
        return Locale::t($key, $vars);
    }
}

if (! function_exists('lurl')) {
    /** URL of a logical path in the current language: {{ lurl('merge-pdf') }} */
    function lurl(string $path = '/'): string
    {
        return Locale::url($path);
    }
}

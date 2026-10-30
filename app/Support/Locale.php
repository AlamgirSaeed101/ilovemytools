<?php

namespace App\Support;

/**
 * Languages: which are supported, URL prefixes, text direction and the
 * interface dictionary (lang/{code}.json). English is the source language and
 * the fallback for anything not translated yet.
 */
class Locale
{
    /** @var array<string, array<string, string>> */
    private static array $ui = [];

    /** @var array<string, array<string, mixed>> */
    private static array $groups = [];

    /** @return array<string, array<string, string>> */
    public static function all(): array
    {
        return (array) config('locales.supported', ['en' => ['name' => 'English', 'native' => 'English', 'dir' => 'ltr', 'og' => 'en_US']]);
    }

    /** @return string[] */
    public static function codes(): array
    {
        return array_keys(self::all());
    }

    /**
     * Languages whose pages may be indexed (config locales.indexable); the default language always is.
     *
     * @return string[]
     */
    public static function indexable(): array
    {
        $codes = (array) config('locales.indexable', self::codes());

        return array_values(array_filter(self::codes(), fn (string $code) => $code === self::default() || in_array($code, $codes, true)));
    }

    public static function isIndexable(?string $code = null): bool
    {
        return in_array($code ?? self::current(), self::indexable(), true);
    }

    public static function default(): string
    {
        return (string) config('locales.default', 'en');
    }

    public static function current(): string
    {
        $locale = app()->getLocale();

        return self::isSupported($locale) ? $locale : self::default();
    }

    public static function isSupported(?string $code): bool
    {
        return $code !== null && array_key_exists($code, self::all());
    }

    public static function dir(?string $locale = null): string
    {
        return self::all()[$locale ?? self::current()]['dir'] ?? 'ltr';
    }

    public static function hreflang(string $locale): string
    {
        return self::all()[$locale]['hreflang'] ?? $locale;
    }

    public static function ogLocale(?string $locale = null): string
    {
        return self::all()[$locale ?? self::current()]['og'] ?? 'en_US';
    }

    /** "" for English, "/es" for Spanish. */
    public static function prefix(?string $locale = null): string
    {
        $locale ??= self::current();

        return $locale === self::default() ? '' : '/'.$locale;
    }

    /** Logical path ("/word-counter", "/") -> path in a language ("/es/word-counter", "/es"). */
    public static function path(string $path, ?string $locale = null): string
    {
        $path = '/'.ltrim($path, '/');
        $prefix = self::prefix($locale);

        return $prefix === '' ? $path : ($path === '/' ? $prefix : $prefix.$path);
    }

    /** Absolute URL of a logical path in a language. */
    public static function url(string $path, ?string $locale = null): string
    {
        return Seo::absoluteUrl(self::path($path, $locale));
    }

    /** Interface dictionary for a language (English keys -> translations). */
    public static function ui(?string $locale = null): array
    {
        $locale ??= self::current();
        if ($locale === self::default()) {
            return [];
        }
        if (! isset(self::$ui[$locale])) {
            $file = lang_path($locale.'.json');
            self::$ui[$locale] = is_file($file) ? (array) json_decode((string) file_get_contents($file), true) : [];
        }

        return self::$ui[$locale];
    }

    /** Translation group file, e.g. lang/es/tools.php. Missing files give []. */
    public static function group(string $group, ?string $locale = null): array
    {
        $locale ??= self::current();
        if ($locale === self::default()) {
            return [];
        }
        $key = $locale.'/'.$group;
        if (! isset(self::$groups[$key])) {
            $file = lang_path($locale.'/'.$group.'.php');
            self::$groups[$key] = is_file($file) ? (array) require $file : [];
        }

        return self::$groups[$key];
    }

    /**
     * Translate interface text. Placeholders use {name}. Values can be plural
     * forms ({"one": "...", "other": "..."}), picked with the "count" variable.
     */
    public static function t(string $key, array $vars = [], ?string $locale = null): string
    {
        $value = self::ui($locale)[$key] ?? $key;
        if (is_array($value)) {
            $count = (float) ($vars['count'] ?? 0);
            $value = ($count == 1 ? ($value['one'] ?? null) : null) ?? $value['other'] ?? $key;
        }
        foreach ($vars as $name => $replacement) {
            $value = str_replace('{'.$name.'}', (string) $replacement, (string) $value);
        }

        return (string) $value;
    }

    /** Clear cached dictionaries (tests). */
    public static function flush(): void
    {
        self::$ui = [];
        self::$groups = [];
    }
}

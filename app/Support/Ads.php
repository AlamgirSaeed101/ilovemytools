<?php

namespace App\Support;

/**
 * Decides what the ad slots show. All settings live in config/site.php (.env).
 *
 *   APP_ENV=production  real Google ads (when ADSENSE_CLIENT is set)
 *   APP_ENV=local       grey "Ad space" placeholders, Google is never loaded
 *   anything else       nothing (e.g. staging), unless ADS_SHOW_PLACEHOLDERS=true
 */
class Ads
{
    /**
     * The AdSense publisher ID, normalised to "ca-pub-" + 16 digits. Accepts the
     * "pub-..." form shown in some AdSense screens; anything malformed is ignored
     * so a typo never loads a broken ad script.
     */
    public static function client(): string
    {
        $client = trim((string) config('site.ads.client', ''));
        if (preg_match('/^(?:ca-)?pub-(\d{16})$/', $client, $m)) {
            return 'ca-pub-'.$m[1];
        }

        return '';
    }

    /** True only in production with a valid publisher ID: load Google's script and real ad units. */
    public static function live(): bool
    {
        return self::client() !== '' && app()->environment('production');
    }

    /** The publisher ID to use on pages: empty outside production, so no real ads load locally. */
    public static function liveClient(): string
    {
        return self::live() ? self::client() : '';
    }

    public static function slotId(string $position): string
    {
        return (string) config('site.ads.slots.'.$position, '');
    }

    /** Placeholders mark where ads go. Never shown alongside real ads. */
    public static function showPlaceholders(): bool
    {
        if (self::live()) {
            return false;
        }

        $setting = config('site.ads.show_placeholders');
        if ($setting === null || $setting === '') {
            return app()->environment('local');
        }

        return filter_var($setting, FILTER_VALIDATE_BOOLEAN);
    }
}

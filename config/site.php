<?php

/*
|--------------------------------------------------------------------------
| Site settings
|--------------------------------------------------------------------------
| Everything you need to rebrand the site or switch on ads lives here and in
| your .env file. No code changes needed.
*/

return [

    'name' => env('APP_NAME', 'ILoveTools'),

    'tagline' => env('SITE_TAGLINE', 'Free Online Tools - Fast, Private, No Sign Up'),

    'description' => env(
        'SITE_DESCRIPTION',
        'Free online tools that run in your browser: word counter, PDF merger, image compressor, QR code generator, calculators and developer utilities. No sign up, no uploads.'
    ),

    'contact_email' => env('CONTACT_EMAIL', 'hello@example.com'),

    // Used in JSON-LD and the Twitter card. Leave empty if you have none.
    'twitter_handle' => env('TWITTER_HANDLE', ''),

    // Default social share image (1200x630) inside /public.
    'og_image' => '/images/og-default.png',

    'theme_color' => '#4f46e5',

    'force_https' => (bool) env('FORCE_HTTPS', true),

    'trusted_proxies' => env('TRUSTED_PROXIES', ''),

    /*
    |--------------------------------------------------------------------------
    | Search engine verification (paste only the "content" value)
    |--------------------------------------------------------------------------
    */
    'verification' => [
        'google' => env('GOOGLE_SITE_VERIFICATION', ''),
        'bing' => env('BING_SITE_VERIFICATION', ''),
    ],

    // Google Analytics 4 measurement ID, e.g. G-XXXXXXXXXX (optional).
    'ga4_id' => env('GA4_MEASUREMENT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Google AdSense
    |--------------------------------------------------------------------------
    | 1. Set ADSENSE_CLIENT=ca-pub-XXXXXXXXXXXXXXXX in .env
    | 2. Create ad units in AdSense and paste their slot IDs below (.env)
    | 3. ads.txt is generated automatically at /ads.txt from the client ID
    |
    | While ADSENSE_CLIENT is empty, grey "Ad space" placeholders are shown
    | locally (APP_ENV=local) and nothing is shown in production.
    */
    'ads' => [
        'client' => env('ADSENSE_CLIENT', ''),
        'show_placeholders' => env('ADS_SHOW_PLACEHOLDERS', null),
        'slots' => [
            'header' => env('ADSENSE_SLOT_HEADER', ''),       // below the navigation
            'below_tool' => env('ADSENSE_SLOT_BELOW_TOOL', ''), // right after the tool (best RPM)
            'sidebar' => env('ADSENSE_SLOT_SIDEBAR', ''),     // desktop sidebar
            'in_content' => env('ADSENSE_SLOT_IN_CONTENT', ''), // between article sections
            'footer' => env('ADSENSE_SLOT_FOOTER', ''),       // above the footer
        ],
    ],

];

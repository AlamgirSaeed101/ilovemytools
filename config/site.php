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
        'Free online tools that run in your browser: word counter, merge PDF, image compressor, QR code generator and calculators. No sign up, no uploads.'
    ),

    'contact_email' => env('CONTACT_EMAIL', 'hello@example.com'),

    // Used in JSON-LD and the Twitter card. Leave empty if you have none.
    'twitter_handle' => env('TWITTER_HANDLE', ''),

    // Default social share image (1200x630) inside /public. Tools use /images/og/{slug}.jpg
    // when it exists (made by `node scripts/og-images.mjs`).
    'og_image' => '/images/og-default.png',

    // Year the site launched (About page and Organization schema).
    'founded' => '2026',

    // The site's own public profiles (AlternativeTo, Product Hunt, GitHub, LinkedIn, X...).
    // They become "sameAs" links that tell Google and AI engines these profiles are the same brand.
    // Add each URL here as soon as the listing is live.
    'same_as' => [
    ],

    // The person behind the site, shown on the About page and in the schema once filled in,
    // e.g. ['name' => 'Jane Doe', 'url' => 'https://www.linkedin.com/in/janedoe'].
    'founder' => null,

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
        // Ask visitors to turn off their ad blocker. Keep false until Google AdSense has approved
        // the site (before that there are no ads to block); then set to true and deploy.
        'adblock_notice' => false,
        'show_placeholders' => env('ADS_SHOW_PLACEHOLDERS', null),
        'slots' => [
            'header' => env('ADSENSE_SLOT_HEADER', ''),       // below the navigation
            'below_tool' => env('ADSENSE_SLOT_BELOW_TOOL', ''), // right after the tool (best RPM)
            'sidebar' => env('ADSENSE_SLOT_SIDEBAR', ''),     // desktop sidebar
            'in_content' => env('ADSENSE_SLOT_IN_CONTENT', ''), // between article sections
            'footer' => env('ADSENSE_SLOT_FOOTER', ''),       // above the footer
        ],
    ],


    /*
    | OpenPageRank API (Domain Authority Checker). Free plan: 30,000 domains a month.
    | The key lives only in the server .env (OPENPAGERANK_API_KEY), set by deploy.sh from a GitHub secret.
    */
    'openpagerank' => [
        'key' => env('OPENPAGERANK_API_KEY'),
        'daily_limit' => (int) env('OPENPAGERANK_DAILY_LIMIT', 900),
    ],
];

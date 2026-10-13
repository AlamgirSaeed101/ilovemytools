<?php

/*
|--------------------------------------------------------------------------
| Site settings
|--------------------------------------------------------------------------
| Everything you need to rebrand the site or switch on ads lives here and in
| your .env file. No code changes needed.
*/

return [

    // Shown everywhere except the logo image; matches the domain ilovemytools.store.
    'name' => env('APP_NAME', 'ILoveMyTools'),

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
    // Shown as a review link in the footer.
    'product_hunt' => '',

    // The company's LinkedIn page, shown as a footer link.
    'linkedin' => 'https://www.linkedin.com/company/ilovemytools',

    // Launch/directory badges shown in the footer: link, one image per theme, alt text and
    // display height in px. Each directory's own image is kept for the theme it was made for
    // (they check for it); the other theme uses a recoloured copy in public/images/badges.
    'badges' => [
        [
            'url' => 'https://startupbase.io/products/ilovemytools?utm_source=startupbase&utm_medium=badge&utm_campaign=launch-badge-dark',
            'light' => '/images/badges/startupbase-light.svg',
            'dark' => 'https://statics.startupbase.io/site/badges/launched-on-sb-dark.svg',
            'alt' => 'Launched on StartupBase',
            'height' => 55,
        ],
        [
            'url' => 'https://circlesaasboard.com/startup/ilovemytools-431315',
            'light' => 'https://circlesaasboard.com/badge.svg',
            'dark' => '/images/badges/circlesaas-dark.svg',
            'alt' => 'Featured on CircleSaaS',
            'height' => 55,
        ],
    ],

    'same_as' => [
        'https://www.uneed.best/tool/ilovetools',
        'https://www.linkedin.com/company/ilovemytools',
        'https://startupbase.io/products/ilovemytools',
        'https://circlesaasboard.com/startup/ilovemytools-431315',
    ],

    // The person behind the site, shown on the About page and in the schema once filled in,
    // e.g. ['name' => 'Jane Doe', 'url' => 'https://www.linkedin.com/in/janedoe'].
    'founder' => ['name' => 'M Alamgir Saeed', 'url' => 'https://www.linkedin.com/in/alamgir-saeed-bse161020'],

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

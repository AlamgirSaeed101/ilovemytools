@php
    // Error pages (404 etc.) don't come from a controller, so give them safe defaults.
    $seo = $seo ?? \App\Support\Seo::make('Page not found', 'The page you are looking for could not be found.')->noindex();
    $boot = $boot ?? [
        'site' => app(\App\Support\SiteData::class)->site(),
        'page' => ['type' => 'notfound', 'slug' => null, 'data' => null],
    ];
    // Real ads only in production; locally the React app shows "Ad space" placeholders instead.
    $adClient = \App\Support\Ads::liveClient();
    $ga4 = (string) config('site.ga4_id');
    $ga4 = app()->environment('production') && preg_match('/^G-[A-Z0-9]{4,20}$/', $ga4) ? $ga4 : '';
@endphp
<!DOCTYPE html>
<html lang="{{ \App\Support\Locale::hreflang(\App\Support\Locale::current()) }}" dir="{{ \App\Support\Locale::dir() }}" class="no-js" data-theme="light">
<head>
    @if ($ga4 !== '')
        {{-- Google tag (gtag.js). GA4 enhanced measurement also records in-app page changes. --}}
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4 }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', @json($ga4));
        </script>
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Primary SEO --}}
    <title>{{ $seo->title }}</title>
    <meta name="description" content="{{ $seo->description }}">
    <meta name="robots" content="{{ $seo->robots }}">
    <link rel="canonical" href="{{ $seo->canonical }}">
    @foreach ($seo->alternates() as $alt)
        <link rel="alternate" hreflang="{{ $alt['hreflang'] }}" href="{{ $alt['href'] }}">
    @endforeach
    {{-- Language on first visit: if the browser's main language is one we have and the visitor opened an
         English page, show the same page in their language. Picking a language in the menu is remembered and
         always wins; pages opened in another language are never changed; search engine bots are never redirected. --}}
    <script>
        (function () {
            var KEY = 'lang-choice';
            try {
                localStorage.setItem(KEY + '-probe', '1');
                localStorage.removeItem(KEY + '-probe');
            } catch (e) {
                return; // can't remember a choice, so never redirect
            }
            document.addEventListener('click', function (e) {
                var a = e.target && e.target.closest ? e.target.closest('a[hreflang]') : null;
                if (a) localStorage.setItem(KEY, a.getAttribute('hreflang').slice(0, 2).toLowerCase());
            }, true);
            if (document.documentElement.lang.slice(0, 2) !== 'en' || localStorage.getItem(KEY)) return;
            if (/bot|crawl|spider|slurp|lighthouse|inspectiontool|preview|headlesschrome/i.test(navigator.userAgent)) return;
            var first = ((navigator.languages && navigator.languages[0]) || navigator.language || '').slice(0, 2).toLowerCase();
            if (first === 'en') return;
            var alt = document.querySelector('link[rel="alternate"][hreflang="' + first + '"]');
            if (alt) location.replace(new URL(alt.href).pathname + location.search + location.hash);
        })();
    </script>

    {{-- Open Graph (Facebook, LinkedIn, WhatsApp) --}}
    <meta property="og:type" content="{{ $seo->ogType }}">
    <meta property="og:site_name" content="{{ config('site.name') }}">
    <meta property="og:title" content="{{ $seo->title }}">
    <meta property="og:description" content="{{ $seo->description }}">
    <meta property="og:url" content="{{ $seo->canonical }}">
    <meta property="og:image" content="{{ $seo->image }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="{{ \App\Support\Locale::ogLocale() }}">

    {{-- Twitter / X --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo->title }}">
    <meta name="twitter:description" content="{{ $seo->description }}">
    <meta name="twitter:image" content="{{ $seo->image }}">
    @if (config('site.twitter_handle'))
        <meta name="twitter:site" content="{{ '@'.ltrim(config('site.twitter_handle'), '@') }}">
    @endif

    {{-- Search engine verification --}}
    @if (config('site.verification.google'))
        <meta name="google-site-verification" content="{{ config('site.verification.google') }}">
    @endif
    @if (config('site.verification.bing'))
        <meta name="msvalidate.01" content="{{ config('site.verification.bing') }}">
    @endif

    {{-- Icons & PWA --}}
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Loaded without blocking the first paint (text shows in the fallback font, then swaps). --}}
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"></noscript>
    @if (\App\Support\Locale::current() === 'ur')
        {{-- Urdu needs its own font (Latin fonts have no Urdu glyphs); loaded only on Urdu pages, same non-blocking pattern as above. --}}
        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap"></noscript>
    @endif

    {{-- Light mode is the default. A saved choice from the theme toggle is applied before the first paint (no flash). --}}
    <script>
        (function (d) {
            d.className = d.className.replace('no-js', 'js');
            try {
                var t = localStorage.getItem('theme');
                if (t === 'dark') {
                    d.setAttribute('data-theme', 'dark');
                    document.querySelector('meta[name="theme-color"]').setAttribute('content', '#0b1020');
                }
            } catch (e) {}
        })(document.documentElement);
    </script>

    {{-- Structured data (JSON-LD) --}}
    @foreach ($seo->schemas as $schema)
        <script type="application/ld+json">{!! $seo->jsonLd($schema) !!}</script>
    @endforeach

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    {{-- Google AdSense (loads async so it never blocks the page) --}}
    @if ($adClient !== '')
        <link rel="preconnect" href="https://pagead2.googlesyndication.com" crossorigin>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adClient }}" crossorigin="anonymous" onerror="window.__adsBlocked=true"></script>
    @endif
</head>
<body>
    {{-- React mounts here and replaces the server-rendered copy below. The copy is
         what crawlers and no-JS visitors read; it is only shown if the app fails to start. --}}
    <div id="app">
        <div class="ssr">
            <a class="skip-link" href="#main">{{ t('Skip to content') }}</a>
            @include('partials.header')
            <main id="main" class="site-main">
                @yield('content')
            </main>
            @include('partials.footer')
        </div>
    </div>

    <script id="boot-data" type="application/json">{!! json_encode($boot, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
</body>
</html>

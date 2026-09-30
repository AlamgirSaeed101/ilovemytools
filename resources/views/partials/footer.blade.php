<footer class="site-footer">
    <div class="shell">
        <div class="footer-grid">
            <div class="footer-brand">
                <a class="logo" href="{{ lurl('/') }}">
                    <img class="logo__img logo__img--light" src="/images/logo.svg?v=3" alt="{{ config('site.name') }}" width="1103" height="234">
                    <img class="logo__img logo__img--dark" src="/images/logo-white.svg?v=3" alt="" width="1103" height="234">
                </a>
                <p>{{ t('Free online tools that run in your browser. No sign up, no uploads, no watermarks.') }}</p>
            </div>

            @foreach ($registry->categories() as $slug => $category)
                <div class="footer-col">
                    <h2 class="footer-col__title"><a href="{{ lurl('category/'.$slug) }}">{{ $category['name'] }}</a></h2>
                    <ul>
                        @foreach ($registry->inCategory($slug) as $toolSlug => $footerTool)
                            <li><a href="{{ lurl($toolSlug) }}">{{ $footerTool['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ config('site.name') }}. {{ t('All rights reserved.') }}</p>
            <ul class="footer-legal">
                <li><a href="{{ lurl('about') }}">{{ t('About') }}</a></li>
                <li><a href="{{ lurl('contact') }}">{{ t('Contact') }}</a></li>
                <li><a href="{{ lurl('privacy-policy') }}">{{ t('Privacy Policy') }}</a></li>
                <li><a href="{{ lurl('terms') }}">{{ t('Terms of Use') }}</a></li>
                <li><a href="{{ url('sitemap.xml') }}">{{ t('Sitemap') }}</a></li>
            </ul>
        </div>
    </div>
</footer>

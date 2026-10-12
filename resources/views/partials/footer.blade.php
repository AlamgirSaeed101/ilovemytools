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
                @if (\App\Support\Locale::current() === \App\Support\Locale::default())
                    <li><a href="{{ url('/guides') }}">Guides</a></li>
                @endif
                @if (config('site.product_hunt'))
                    <li><a href="{{ config('site.product_hunt') }}" target="_blank" rel="noopener">★ {{ t('Review us on Product Hunt') }}</a></li>
                @endif
                @if (config('site.linkedin'))
                    <li><a href="{{ config('site.linkedin') }}" target="_blank" rel="noopener">LinkedIn</a></li>
                @endif
                <li><a href="{{ url('sitemap.xml') }}">{{ t('Sitemap') }}</a></li>
            </ul>
            @if (config('site.startupbase'))
                <a class="footer-badge" href="{{ config('site.startupbase') }}" target="_blank" rel="noopener noreferrer">
                    <img src="https://statics.startupbase.io/site/badges/launched-on-sb-dark.svg" alt="Launched on StartupBase" height="55" style="height:55px;width:auto;" loading="lazy">
                </a>
            @endif
        </div>
    </div>
</footer>

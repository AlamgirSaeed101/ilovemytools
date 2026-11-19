<footer class="site-footer">
    <div class="shell">
        <div class="footer-grid">
            <div class="footer-brand">
                <a class="logo" href="{{ lurl('/') }}">
                    <img class="logo__img logo__img--light" src="/images/logo.svg?v=3" alt="{{ config('site.name') }}" width="1103" height="234">
                    <img class="logo__img logo__img--dark" src="/images/logo-white.svg?v=3" alt="{{ config('site.name') }}" width="1103" height="234">
                </a>
                <p>{{ t('Free online tools that run in your browser. No sign up, no uploads, no watermarks.') }}</p>
            </div>

            @foreach ($registry->categories() as $slug => $category)
                <div class="footer-col">
                    <p class="footer-col__title"><a href="{{ lurl('category/'.$slug) }}">{{ $category['name'] }}</a></p>
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
                @if (! empty(config('site.founder.name')))
                    <li><a href="{{ url(\App\Support\Guides::AUTHOR_PATH) }}" rel="author">{{ config('site.founder.name') }}</a></li>
                @endif
                <li><a href="{{ lurl('contact') }}">{{ t('Contact') }}</a></li>
                <li><a href="{{ lurl('privacy-policy') }}">{{ t('Privacy Policy') }}</a></li>
                <li><a href="{{ lurl('terms') }}">{{ t('Terms of Use') }}</a></li>
                {{-- In every language: the English guides hub (guides have no translations). --}}
                <li><a href="{{ url('/guides') }}">{{ t('All guides') }}</a></li>
                @if (config('site.product_hunt'))
                    <li><a href="{{ config('site.product_hunt') }}" target="_blank" rel="noopener">★ {{ t('Review us on Product Hunt') }}</a></li>
                @endif
                @if (config('site.linkedin'))
                    <li><a href="{{ config('site.linkedin') }}" target="_blank" rel="noopener">LinkedIn</a></li>
                @endif
                <li><a href="{{ url('sitemap.xml') }}">{{ t('Sitemap') }}</a></li>
            </ul>
            @if (config('site.badges'))
                <div class="footer-badges">
                    @foreach (config('site.badges') as $badge)
                        <a class="footer-badge{{ ! empty($badge['class']) ? ' '.$badge['class'] : '' }}" href="{{ $badge['url'] }}" target="_blank" rel="{{ $badge['rel'] ?? 'noopener noreferrer' }}">
                            @if (! empty($badge['src']))
                                <img src="{{ $badge['src'] }}" width="{{ $badge['width'] }}" height="{{ $badge['height'] }}" alt="{{ $badge['alt'] }}" loading="lazy">
                            @else
                                <img class="footer-badge__img--light" src="{{ $badge['light'] }}" alt="{{ $badge['alt'] }}" height="{{ $badge['height'] }}" style="height:{{ $badge['height'] }}px;width:auto;" loading="lazy">
                                <img class="footer-badge__img--dark" src="{{ $badge['dark'] }}" alt="{{ $badge['alt'] }}" height="{{ $badge['height'] }}" style="height:{{ $badge['height'] }}px;width:auto;" loading="lazy">
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
            @if ($tp = config('site.trustpilot'))
                {{-- Trustpilot Review Collector. The script is loaded by the React footer when this
                     scrolls into view; the link inside is what no-JS visitors and crawlers get. --}}
                <div class="footer-trustpilot">
                    <div class="trustpilot-widget" data-locale="{{ $tp['locales'][\App\Support\Locale::current()] ?? 'en-US' }}" data-template-id="{{ $tp['template_id'] }}" data-businessunit-id="{{ $tp['business_unit_id'] }}" data-style-height="{{ $tp['height'] }}px" data-style-width="100%" style="height:{{ $tp['height'] }}px">
                        <a href="{{ $tp['url'] }}" target="_blank" rel="noopener">{{ t('Review us on Trustpilot') }}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</footer>

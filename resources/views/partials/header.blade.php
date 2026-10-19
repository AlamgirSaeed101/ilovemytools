<header class="site-header">
    <div class="shell site-header__inner">
        <a class="logo" href="{{ lurl('/') }}" aria-label="{{ t('{name} home', ['name' => config('site.name')]) }}">
            <img class="logo__img logo__img--light" src="/images/logo.svg?v=3" alt="{{ config('site.name') }}" width="1103" height="234">
            <img class="logo__img logo__img--dark" src="/images/logo-white.svg?v=3" alt="{{ config('site.name') }}" width="1103" height="234">
        </a>

        <nav id="site-nav" class="site-nav" aria-label="{{ t('Main') }}">
            <ul>
                @foreach ($registry->categories() as $slug => $category)
                    <li><a href="{{ lurl('category/'.$slug) }}">{{ $category['name'] }}</a></li>
                @endforeach
            </ul>
        </nav>

        {{-- Plain links to every language, for crawlers and visitors without JavaScript. --}}
        <nav class="lang-list" aria-label="{{ t('Language') }}">
            <ul>
                @foreach (\App\Support\Locale::all() as $code => $lang)
                    <li><a href="{{ \App\Support\Locale::url($seo->path ?? '/', $code) }}" hreflang="{{ \App\Support\Locale::hreflang($code) }}" lang="{{ $code }}" @if ($code === \App\Support\Locale::current()) aria-current="true" @endif>{{ $lang['native'] }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>

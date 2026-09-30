@extends('layouts.app')

@section('content')
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article">
            @if (\App\Support\Locale::current() === \App\Support\Locale::default())
            <h1>Terms of Use</h1>
            <p class="muted">Last updated: {{ \Carbon\Carbon::parse(\App\Support\SiteData::LEGAL_UPDATED)->format('j F Y') }}</p>

            <p>By using {{ config('site.name') }} (the "Site") you agree to these terms. If you do not agree, please do not use the Site.</p>

            <h2>1. Use of the tools</h2>
            <p>The tools are provided free of charge for personal and commercial use. You are responsible for the files and content you process and for making sure you have the right to use them.</p>

            <h2>2. No warranty</h2>
            <p>The Site and tools are provided "as is" and "as available", without warranties of any kind. While we work hard to make every tool accurate, we do not guarantee that results will be error-free. Always keep a copy of your original files and double-check important results such as calculations.</p>

            <h2>3. Limitation of liability</h2>
            <p>To the fullest extent permitted by law, {{ config('site.name') }} is not liable for any loss or damage, including loss of data or profits, arising from your use of the Site or tools.</p>

            <h2>4. Acceptable use</h2>
            <p>You agree not to misuse the Site, including attempting to disrupt it, overload it with automated requests, or use it for unlawful purposes.</p>

            <h2>5. Advertising and third-party links</h2>
            <p>The Site shows advertisements and may link to third-party websites. We are not responsible for the content or practices of those websites.</p>

            <h2>6. Changes</h2>
            <p>We may update these terms at any time. Continued use of the Site after changes means you accept the new terms.</p>

            <h2>7. Contact</h2>
            <p>Questions? Email <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a>.</p>
                    @else
                <h1>{{ $pageTitle }}</h1>
                <p>{{ $seo->description }}</p>
            @endif
        </article>
    </div>
@endsection

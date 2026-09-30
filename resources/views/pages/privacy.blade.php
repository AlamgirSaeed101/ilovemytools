@extends('layouts.app')

@section('content')
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article">
            @if (\App\Support\Locale::current() === \App\Support\Locale::default())
            <h1>Privacy Policy</h1>
            <p class="muted">Last updated: {{ \Carbon\Carbon::parse(\App\Support\SiteData::LEGAL_UPDATED)->format('j F Y') }}</p>

            <p>This Privacy Policy explains how {{ config('site.name') }} ("we", "us") handles information when you use {{ url('/') }} (the "Site"). Please also read the section about advertising cookies below.</p>

            <h2>1. Files and text you use in our tools</h2>
            <p>Our tools (for example the PDF, image and text tools) run entirely inside your web browser. The files, images and text you process are <strong>not uploaded to our servers</strong>, are not stored by us and are not visible to us. When you close the page, the data is gone.</p>
            <p>The only exception is the "What Is My IP" tool, which shows you the IP address your browser used to reach our server. We display it back to you and do not store it in a database.</p>

            <h2>2. Information collected automatically</h2>
            <p>Like most websites, our web server may keep standard log files that include your IP address, browser type, pages visited and the date and time of the visit. These logs are used only for security, troubleshooting and preventing abuse, and are deleted regularly.</p>

            <h2>3. Cookies</h2>
            <p>Cookies are small text files stored on your device. We use:</p>
            <ul>
                <li><strong>Essential cookies</strong> needed for the Site to work securely (for example a session cookie).</li>
                <li><strong>Analytics cookies</strong> (if enabled) such as Google Analytics, to understand how visitors use the Site in aggregate.</li>
                <li><strong>Advertising cookies</strong> used by Google and its partners to show ads, as described below.</li>
            </ul>

            <h2>4. Advertising (Google AdSense)</h2>
            <p>We use Google AdSense to show advertisements. Third-party vendors, including Google, use cookies to serve ads based on your prior visits to this Site or other websites.</p>
            <p>Google's use of advertising cookies enables it and its partners to serve ads to you based on your visits to this Site and/or other sites on the Internet.</p>
            <p>You may opt out of personalised advertising by visiting <a href="https://adssettings.google.com" rel="nofollow noopener" target="_blank">Google Ads Settings</a>. You can also opt out of some third-party vendors' use of cookies for personalised advertising at <a href="https://www.aboutads.info/choices/" rel="nofollow noopener" target="_blank">www.aboutads.info</a>. Learn more in <a href="https://policies.google.com/technologies/partner-sites" rel="nofollow noopener" target="_blank">how Google uses information from sites that use its services</a>.</p>
            <p>Visitors in the European Economic Area, the UK and Switzerland are asked for consent through a Google-certified consent management platform before personalised ads are shown.</p>

            <h2>5. Your rights</h2>
            <p>Depending on where you live (for example under the GDPR or UK GDPR, or the CCPA in California), you may have the right to access, correct or delete personal data, and to object to or restrict certain processing. Because we do not store your tool data, there is usually no personal data for us to return. To make a request, contact us using the details below.</p>

            <h2>6. Children</h2>
            <p>The Site is not directed at children under 13, and we do not knowingly collect personal information from them.</p>

            <h2>7. Changes to this policy</h2>
            <p>We may update this policy from time to time. The "Last updated" date above shows when it last changed.</p>

            <h2>8. Contact</h2>
            <p>Questions about privacy? Email <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a>.</p>
                    @else
                <h1>{{ $pageTitle }}</h1>
                <p>{{ $seo->description }}</p>
            @endif
        </article>
    </div>
@endsection

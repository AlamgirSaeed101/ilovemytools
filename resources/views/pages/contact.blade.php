@extends('layouts.app')

@section('content')
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article">
            @if (\App\Support\Locale::current() === \App\Support\Locale::default())
            <h1>Contact Us</h1>
            <p>We read every message. Get in touch to:</p>
            <ul>
                <li>Report a bug or a tool that is not working as expected</li>
                <li>Suggest a new tool you would like us to build</li>
                <li>Ask about advertising or partnerships</li>
                <li>Send privacy or legal requests</li>
            </ul>

            <div class="contact-card">
                <p class="contact-card__label">Email us at</p>
                <p class="contact-card__email"><a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a></p>
                <p class="contact-card__note">We usually reply within 2 business days.</p>
            </div>

            <p>When reporting a problem, please tell us which tool you used, your browser (for example Chrome or Safari) and your device, so we can fix it quickly.</p>
                    @else
                <h1>{{ $pageTitle }}</h1>
                <p>{{ $seo->description }}</p>
            @endif
        </article>
    </div>
@endsection

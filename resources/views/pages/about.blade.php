@extends('layouts.app')

@section('content')
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article">
            @if (\App\Support\Locale::current() === \App\Support\Locale::default())
            <h1>About {{ config('site.name') }}</h1>
            <p>{{ config('site.name') }} is a free collection of simple, fast and private online tools. We built it because most "free" tools online are slow, covered in pop-ups, add watermarks, or quietly upload your files to their servers.</p>

            <h2>Our approach</h2>
            <ul>
                <li><strong>Privacy first.</strong> Our tools process your files and text directly in your web browser. PDFs, images and documents never leave your device.</li>
                <li><strong>Free forever.</strong> Every tool is free with no account, no daily limit and no watermark. The site is supported by unobtrusive advertising.</li>
                <li><strong>Fast and simple.</strong> Each tool does one job well, loads quickly and works on phones, tablets and computers.</li>
            </ul>

            <h2>Our tools</h2>
            <p>We currently offer {{ $registry->all()->count() }} free tools across {{ $registry->categories()->count() }} categories, including a word counter, PDF merger, image compressor, QR code generator, calculators and developer utilities, and we add new tools regularly.</p>

            <h2>Get in touch</h2>
            <p>Have an idea for a new tool or found a bug? We would love to hear from you on our <a href="{{ route('contact') }}">contact page</a>.</p>
                    @else
                <h1>{{ $pageTitle }}</h1>
                <p>{{ $seo->description }}</p>
            @endif
        </article>
    </div>
@endsection

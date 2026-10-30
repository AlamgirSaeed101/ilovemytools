@extends('layouts.app')

@section('content')
    @php($name = config('site.name'))
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article">
            <h1>{{ t('About {name}', ['name' => $name]) }}</h1>
            <p class="lead">{{ t('{name} is a free collection of simple, fast and private online tools. We built it because most “free” tools online are slow, covered in pop-ups, add watermarks, or quietly upload your files to their servers.', ['name' => $name]) }}</p>
            <p>{{ t('{name} launched in {year}. Everything on the site is free to use and is paid for by advertising.', ['name' => $name, 'year' => config('site.founded')]) }}</p>
            @if ($founder = config('site.founder'))
                <p>{{ t('{name} was founded by {founder}.', ['name' => $name, 'founder' => $founder['name']]) }}</p>
            @endif

            @if (\App\Support\Locale::current() === \App\Support\Locale::default())
                <h2>{{ $name }} at a glance</h2>
                @foreach (\App\Support\BrandFaq::all() as $faq)
                    <h3>{{ $faq['q'] }}</h3>
                    <p>{{ $faq['a'] }}</p>
                @endforeach
            @endif

            <h2>{{ t('Privacy first') }}</h2>
            <p>{{ t('Our tools process your files and text directly in your web browser. PDFs, images and documents never leave your device.') }}</p>
            <h2>{{ t('Free forever') }}</h2>
            <p>{{ t('Every tool is free with no account, no daily limit and no watermark. The site is supported by unobtrusive advertising.') }}</p>
            <h2>{{ t('Fast and simple') }}</h2>
            <p>{{ t('Each tool does one job well, loads quickly and works on phones, tablets and computers.') }}</p>

            <h2>{{ t('How we build and test our tools') }}</h2>
            <p>{{ t('Our tools are built on well-known open-source libraries, such as PDF.js from Mozilla and pdf-lib for PDFs, and run inside your browser.') }}</p>
            <p>{{ t('Before every release, automated tests open every tool in every language and check real results, for example that a merged PDF has the right pages or that a compressed image is smaller.') }}</p>
            <p>{{ t('Formulas and facts on our pages come from published standards and research, listed under “Sources” on each tool page.') }}</p>

            <h2>{{ t('How to check that your files stay private') }}</h2>
            <p>{{ t('Open your browser’s developer tools, choose the Network tab and use any tool: you will see that your file is never sent anywhere. The few tools that need to look something up online, such as the Broken Link Checker, say so clearly on the page.') }}</p>

            <h2>{{ t('Our tools') }}</h2>
            <p>{{ t('We currently offer {tools} free tools across {categories} categories, including a word counter, PDF merger, image compressor, QR code generator, calculators, games, timers and developer utilities, and we add new tools regularly.', ['tools' => $registry->all()->count(), 'categories' => $registry->categories()->count()]) }}</p>

            <h2>{{ t('Corrections') }}</h2>
            <p>{{ t('If you find a mistake in a result or on a page, please tell us and we will correct it. Each tool page shows when it was last updated.') }}</p>

            <h2>{{ t('Get in touch') }}</h2>
            @php($contactLink = '<a href="'.e(lurl('contact')).'">'.e(t('contact page')).'</a>')
            <p>{!! str_replace('__LINK__', $contactLink, e(t('Have an idea for a new tool or found a bug? We would love to hear from you on our {link}.', ['link' => '__LINK__']))) !!}</p>
        </article>
    </div>
@endsection

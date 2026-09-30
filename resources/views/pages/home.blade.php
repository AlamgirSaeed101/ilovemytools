@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="shell hero__inner">
            <h1 class="hero__title">{{ t('All the free online tools you need, in one place') }}</h1>
            <p class="hero__lead">{{ t('Every tool you need for PDFs, images, text, maths and code, right in your browser. All are 100% free and private: merge PDFs, compress images, count words, make QR codes and more in just a few clicks.') }}</p>
        </div>
    </section>

    <div class="shell">
        @foreach ($categories as $slug => $category)
            <section class="section" id="{{ $slug }}" aria-labelledby="heading-{{ $slug }}">
                <div class="section__head">
                    <h2 id="heading-{{ $slug }}" class="section__title">{{ $category['name'] }}</h2>
                    <a class="section__link" href="{{ lurl('category/'.$slug) }}">{{ t('View all') }}</a>
                </div>
                <div class="tool-grid">
                    @foreach ($registry->inCategory($slug) as $card)
                        @include('partials.tool-card', ['card' => $card])
                    @endforeach
                </div>
            </section>
        @endforeach

        <section class="section prose" aria-labelledby="why-heading">
            <h2 id="why-heading">{{ t('Free tools people can trust') }}</h2>
            <p>{{ t('{name} is a free web app for everyday tasks with PDFs, images, text and data. Every tool runs in your browser, so your work stays private and results appear instantly.', ['name' => config('site.name')]) }}</p>
        </section>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="shell">
        @include('partials.breadcrumbs')

        <header class="page-header">
            <h1>{{ $category['name'] }}</h1>
            <p class="page-header__lead">{{ $category['intro'] }}</p>
        </header>

        <section class="section" aria-label="{{ $category['name'] }}">
            <div class="tool-grid">
                @foreach ($tools as $card)
                    @include('partials.tool-card', ['card' => $card])
                @endforeach
            </div>
        </section>

        <article class="prose tool-article">
            <h2 id="compare">{{ t('Which tool do you need?') }}</h2>
            <div class="table-wrap">
                <table class="compare-table">
                    <thead><tr><th scope="col">{{ t('Tool') }}</th><th scope="col">{{ t('What it does') }}</th></tr></thead>
                    <tbody>
                        @foreach ($tools as $card)
                            <tr><th scope="row"><a href="{{ lurl($card['slug']) }}">{{ $card['name'] }}</a></th><td>{{ $card['tagline'] }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach ($category['content'] ?? [] as $section)
                <h2>{{ $section['heading'] }}</h2>
                <p>{{ $section['body'] }}</p>
            @endforeach

            @if (! empty($category['faqs']))
                <h2 id="faq">{{ t('Frequently asked questions') }}</h2>
                <div class="faq">
                    @foreach ($category['faqs'] as $faq)
                        <details class="faq__item" @if ($loop->first) open @endif>
                            <summary><h3 class="faq__q">{{ $faq['q'] }}</h3></summary>
                            <p>{{ $faq['a'] }}</p>
                        </details>
                    @endforeach
                </div>
            @endif
        </article>

        <section class="section" aria-labelledby="other-heading">
            <h2 id="other-heading" class="section__title">{{ t('Other categories') }}</h2>
            <ul class="chip-list">
                @foreach ($otherCategories as $slug => $other)
                    <li><a class="chip" href="{{ lurl('category/'.$slug) }}">{!! \App\Support\Icon::svg($other['icon']) !!} {{ $other['name'] }}</a></li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection

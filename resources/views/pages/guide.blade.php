@extends('layouts.app')

@section('content')
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article guide-article">
            <h1>{{ $guide['h1'] }}</h1>
            <p class="text-sm text-muted">By <a href="{{ url(\App\Support\Guides::AUTHOR_PATH) }}" rel="author">{{ \App\Support\Guides::author() }}</a> · Updated <time datetime="{{ $guide['updated'] }}">{{ \Illuminate\Support\Carbon::parse($guide['updated'])->isoFormat('LL') }}</time></p>
            <p class="lead">{{ $guide['intro'] }}</p>

            <nav class="toc" aria-labelledby="toc-title">
                <p id="toc-title" class="toc__title">On this page</p>
                <ol>
                    @foreach ($guide['sections'] as $section)
                        <li><a href="#{{ \App\Support\Guides::headingId($section['heading']) }}">{{ $section['heading'] }}</a></li>
                    @endforeach
                    @if ($guide['faqs'] !== [])
                        <li><a href="#faq">Frequently asked questions</a></li>
                    @endif
                </ol>
            </nav>

            @foreach ($guide['sections'] as $section)
                <h2 id="{{ \App\Support\Guides::headingId($section['heading']) }}">{{ $section['heading'] }}</h2>
                @foreach ($section['paragraphs'] ?? [] as $paragraph)
                    <p>{{ \App\Support\Guides::inline($paragraph) }}</p>
                @endforeach
                @if (! empty($section['list']))
                    <ul>
                        @foreach ($section['list'] as $item)
                            <li>{{ \App\Support\Guides::inline($item) }}</li>
                        @endforeach
                    </ul>
                @endif
                @if (! empty($section['table']))
                    <div class="table-wrap">
                        <table class="compare-table">
                            <thead><tr>@foreach ($section['table']['headers'] as $h)<th scope="col">{{ $h }}</th>@endforeach</tr></thead>
                            <tbody>
                                @foreach ($section['table']['rows'] as $row)
                                    <tr>@foreach ($row as $i => $cell)@if ($i === 0)<th scope="row">{{ $cell }}</th>@else<td>{{ $cell }}</td>@endif @endforeach</tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach

            @if ($tool)
                <p><a class="btn btn--primary" href="{{ url('/'.$tool['slug']) }}">Try the free {{ $tool['name'] }}</a></p>
            @endif

            @if ($guide['faqs'] !== [])
                <h2 id="faq">Frequently asked questions</h2>
                @foreach ($guide['faqs'] as $faq)
                    <h3>{{ $faq['q'] }}</h3>
                    <p>{{ $faq['a'] }}</p>
                @endforeach
            @endif

            @if ($guide['sources'] !== [])
                <h2>Sources</h2>
                <ul class="sources">
                    @foreach ($guide['sources'] as $source)
                        <li><a href="{{ $source['url'] }}" target="_blank" rel="noopener noreferrer">{{ $source['title'] }}</a></li>
                    @endforeach
                </ul>
            @endif
        </article>

        @if (! empty($moreGuides))
            <section class="section" aria-labelledby="more-guides-heading">
                <h2 id="more-guides-heading" class="section__title">More guides</h2>
                <ul class="guide-links">
                    @foreach ($moreGuides as $more)
                        <li>
                            <a href="{{ url('/guides/'.$more['slug']) }}">{{ $more['title'] }}</a>
                            <p>{{ $more['description'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
@endsection

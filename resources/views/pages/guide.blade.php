@extends('layouts.app')

@section('content')
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article guide-article">
            <h1>{{ $guide['h1'] }}</h1>
            <p class="text-sm text-muted">By <a href="{{ url('/about') }}">{{ \App\Support\Guides::author() }}</a> · Updated <time datetime="{{ $guide['updated'] }}">{{ \Illuminate\Support\Carbon::parse($guide['updated'])->isoFormat('LL') }}</time></p>
            <p class="lead">{{ $guide['intro'] }}</p>

            @foreach ($guide['sections'] as $section)
                <h2>{{ $section['heading'] }}</h2>
                @foreach ($section['paragraphs'] ?? [] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
                @if (! empty($section['list']))
                    <ul>
                        @foreach ($section['list'] as $item)
                            <li>{{ $item }}</li>
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
                <h2>Frequently asked questions</h2>
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
    </div>
@endsection

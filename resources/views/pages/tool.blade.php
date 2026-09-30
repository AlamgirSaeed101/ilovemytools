@extends('layouts.app')

@section('content')
    <div class="shell">
        @include('partials.breadcrumbs')

        <header class="tool-header">
            <span class="tool-header__icon">{!! \App\Support\Icon::svg($tool['icon'] ?? 'sparkles') !!}</span>
            <div>
                <h1 class="tool-header__title">{{ $tool['h1'] }}</h1>
                <p class="tool-header__tagline">{{ $tool['tagline'] }}</p>
            </div>
        </header>

        <div class="layout">
            <div class="layout__main">
                {{-- The React app renders the working tool here. --}}
                <section class="tool-panel" aria-label="{{ $tool['name'] }}">
                    <p class="notice notice--warn">{{ t('This tool needs JavaScript. Please enable JavaScript in your browser settings to use the {name}.', ['name' => $tool['name']]) }}</p>
                    <p class="privacy-note">{!! \App\Support\Icon::svg('shield') !!} {{ t('Private: this tool runs in your browser. Your data is never uploaded.') }}</p>
                </section>

                <article class="prose tool-article">
                    <h2>{{ t('About the {name}', ['name' => $tool['name']]) }}</h2>
                    <p class="tool-intro">{{ $tool['intro'] }}</p>

                    @if ($tool['steps'] !== [])
                        <h2 id="how-to">{{ t('How to use the {name}', ['name' => $tool['name']]) }}</h2>
                        <ol class="steps">
                            @foreach ($tool['steps'] as $step)
                                <li>{{ $step }}</li>
                            @endforeach
                        </ol>
                    @endif

                    @if ($tool['features'] !== [])
                        <h2>{{ t('Features') }}</h2>
                        <ul class="checklist">
                            @foreach ($tool['features'] as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @foreach ($tool['content'] as $section)
                        <h2>{{ $section['heading'] }}</h2>
                        <p>{{ $section['body'] }}</p>
                    @endforeach

                    @if (! empty($tool['table']))
                        <div class="table-wrap">
                            <table class="compare-table">
                                <caption>{{ $tool['table']['caption'] }}</caption>
                                <thead>
                                    <tr>
                                        @foreach ($tool['table']['headers'] as $h)
                                            <th scope="col">{{ $h }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tool['table']['rows'] as $row)
                                        <tr>
                                            @foreach ($row as $i => $cell)
                                                @if ($i === 0)
                                                    <th scope="row">{{ $cell }}</th>
                                                @else
                                                    <td>{{ $cell }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($tool['faqs'] !== [])
                        <h2 id="faq">{{ t('Frequently asked questions') }}</h2>
                        <div class="faq">
                            @foreach ($tool['faqs'] as $faq)
                                <details class="faq__item" @if ($loop->first) open @endif>
                                    <summary><h3 class="faq__q">{{ $faq['q'] }}</h3></summary>
                                    <p>{{ $faq['a'] }}</p>
                                </details>
                            @endforeach
                        </div>
                    @endif

                    @if (! empty($tool['sources']))
                        <h2 id="sources">{{ t('Sources') }}</h2>
                        <ul class="sources">
                            @foreach ($tool['sources'] as $source)
                                <li><a href="{{ $source['url'] }}" target="_blank" rel="noopener noreferrer">{{ $source['title'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </article>

                @if ($related->isNotEmpty())
                    <section class="section" aria-labelledby="related-heading">
                        <h2 id="related-heading" class="section__title">{{ t('Related tools') }}</h2>
                        <div class="tool-grid">
                            @foreach ($related as $card)
                                @include('partials.tool-card', ['card' => $card])
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <aside class="layout__side" aria-label="{{ t('More tools') }}">
                <nav class="side-list" aria-labelledby="side-heading">
                    <h2 id="side-heading" class="side-list__title">{{ t('More in {category}', ['category' => $category['name'] ?? t('Tools')]) }}</h2>
                    <ul>
                        @foreach ($registry->inCategory($tool['category']) as $sideSlug => $sideTool)
                            <li>
                                <a href="{{ lurl($sideSlug) }}" @if ($sideSlug === $tool['slug']) aria-current="page" @endif>
                                    {!! \App\Support\Icon::svg($sideTool['icon'] ?? 'sparkles') !!} {{ $sideTool['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <a class="side-list__all" href="{{ lurl('/') }}">{{ t('All free tools') }} {!! \App\Support\Icon::svg('arrow') !!}</a>
                </nav>
            </aside>
        </div>
    </div>
@endsection

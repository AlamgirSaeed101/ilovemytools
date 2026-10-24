@extends('layouts.app')

@section('content')
    {{-- Same markup and classes as the React ToolPage header, so the first paint and React's render
         are the same size: nothing re-renders larger (LCP) or moves (CLS) when the app takes over. --}}
    <div class="shell" @if (! empty($category['accent'])) style="--accent: {{ $category['accent'] }}; --accent2: {{ $category['accent2'] ?? $category['accent'] }}" @endif>
        @include('partials.breadcrumbs')

        <header class="mb-6 flex items-start gap-3 sm:gap-[1.1rem]">
            <span class="icon-tile icon-tile--lg">{!! \App\Support\Icon::svg($tool['icon'] ?? 'sparkles') !!}</span>
            <div class="min-w-0">
                <h1 class="m-0 mb-1 text-[clamp(1.6rem,4vw,2.5rem)] font-extrabold tracking-tight [overflow-wrap:anywhere] hyphens-auto">{{ $tool['h1'] }}</h1>
                <p class="m-0 text-[1.08rem] text-ink-2">{{ $tool['tagline'] }}</p>
                <ul class="mt-3 flex list-none flex-wrap gap-1.5 p-0">
                    @foreach ([['gift', 'Free'], ['shield', 'Runs in your browser'], ['zap', 'No sign up']] as [$badgeIcon, $badgeLabel])
                        <li class="inline-flex items-center gap-1.5 rounded-full border border-line bg-surface px-2.5 py-1 text-[0.8rem] font-semibold text-ink-2 [&_svg]:text-success">{!! \App\Support\Icon::svg($badgeIcon) !!} {{ t($badgeLabel) }}</li>
                    @endforeach
                </ul>
            </div>
        </header>

        <div class="layout">
            <div class="layout__main">
                {{-- The React app renders the working tool here. --}}
                @php($panel = \App\Support\SiteData::panelHeight($tool['slug']))
                <section class="tool-panel" aria-label="{{ $tool['name'] }}" @if ($panel) style="--panel-sm: {{ $panel['sm'] }}px; --panel-lg: {{ $panel['lg'] }}px" @endif>
                    {{-- Hidden by CSS once the page's own inline script marks <html> as "js" (see layouts.app), so it's only
                         ever shown to real browsers with JavaScript off and to crawlers/AI engines that don't run JS. --}}
                    <p class="notice notice--warn no-js-notice">{{ t('This tool needs JavaScript. Please enable JavaScript in your browser settings to use the {name}.', ['name' => $tool['name']]) }}</p>
                    <p class="privacy-note">{!! \App\Support\Icon::svg('shield') !!} {{ ! empty($tool['server']) ? t('This tool asks our server to fetch the address you enter. We don’t store the address or the results.') : t('Private: this tool runs in your browser. Your data is never uploaded.') }}</p>
                </section>

                <article class="prose tool-article">
                    <h2>{{ t('What is the {name} tool?', ['name' => $tool['name']]) }}</h2>
                    <p class="tool-intro">{{ $tool['intro'] }}</p>
                    @if (! empty($tool['updated']))
                        <p class="text-sm text-muted"><time datetime="{{ $tool['updated'] }}">{{ t('Last updated: {date}', ['date' => \Illuminate\Support\Carbon::parse($tool['updated'])->locale(\App\Support\Locale::current())->isoFormat('LL')]) }}</time></p>
                    @endif

                    @if ($tool['steps'] !== [])
                        <h2 id="how-to">{{ t('How to use the {name} tool', ['name' => $tool['name']]) }}</h2>
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

                @if (! empty($guides))
                    <section class="section cv-auto" aria-labelledby="guides-heading">
                        <h2 id="guides-heading" class="section__title">{{ t('Read the guide') }}</h2>
                        <ul class="guide-links">
                            @foreach ($guides as $guide)
                                <li>
                                    <a href="{{ url('/guides/'.$guide['slug']) }}">{{ $guide['title'] }}</a>
                                    <p>{{ $guide['description'] }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if ($related->isNotEmpty())
                    <section class="section cv-auto" aria-labelledby="related-heading">
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

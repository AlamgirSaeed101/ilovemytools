@extends('layouts.app')

@section('content')
    <div class="shell shell--narrow">
        <div class="error-page">
            <p class="error-page__code">404</p>
            <h1>{{ t('Page not found') }}</h1>
            <p>{{ t("Sorry, we couldn't find that page. It may have moved, or the link may be wrong.") }}</p>
            <a class="btn btn--primary" href="{{ lurl('/') }}">{{ t('Browse all free tools') }}</a>
        </div>

        <section class="section" aria-labelledby="popular-404">
            <h2 id="popular-404" class="section__title">{{ t('Popular tools') }}</h2>
            <div class="tool-grid">
                @foreach ($registry->popular()->take(6) as $card)
                    @include('partials.tool-card', ['card' => $card])
                @endforeach
            </div>
        </section>
    </div>
@endsection

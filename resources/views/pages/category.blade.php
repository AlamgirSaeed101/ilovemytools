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

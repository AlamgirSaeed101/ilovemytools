@extends('layouts.app')

@section('content')
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article">
            <h1>Guides</h1>
            <p class="lead">Practical, step-by-step guides written by {{ \App\Support\Guides::author() }}: how to get files to the right size, pick the right format and finish everyday tasks faster.</p>
            @foreach ($guides as $guide)
                <h2><a href="{{ url('/guides/'.$guide['slug']) }}">{{ $guide['h1'] }}</a></h2>
                <p>{{ $guide['description'] }}</p>
            @endforeach
        </article>
    </div>
@endsection

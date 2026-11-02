@extends('layouts.app')

{{-- The founder's author page (English only; resources/js/pages/Author.jsx renders the same content). --}}
@section('content')
    @php($site = config('site.name'))
    <div class="shell shell--narrow">
        @include('partials.breadcrumbs')
        <article class="prose page-article" lang="en">
            <h1>{{ $founder['name'] }}</h1>
            <p class="lead">Founder and developer of {{ $site }}, based in Islamabad, Pakistan.</p>
            <p>{{ $founder['name'] }} is a full-stack developer. He founded {{ $site }} in {{ config('site.founded') }} and builds and maintains every tool on the site: {{ count(config('tools', [])) }} free online tools for PDFs, images, text, calculations and developers, available in {{ count(\App\Support\Locale::all()) }} languages.</p>
            <p>The file tools run in your browser with open-source libraries such as PDF.js and pdf-lib, so your files are never uploaded. Before every release, automated tests open every tool in every language and check real results.</p>

            <h2>Guides by {{ $founder['name'] }}</h2>
            <ul>
                @foreach ($guides as $guide)
                    <li><a href="{{ url('/guides/'.$guide['slug']) }}">{{ $guide['h1'] }}</a> - {{ $guide['description'] }}</li>
                @endforeach
            </ul>

            @if (! empty($founder['same_as']))
                <h2>Profiles</h2>
                <ul>
                    @foreach ($founder['same_as'] as $profile)
                        <li><a href="{{ $profile }}" rel="me noopener noreferrer" target="_blank">{{ \App\Support\Guides::profileLabel($profile) }}</a></li>
                    @endforeach
                </ul>
            @endif

            <p>Found a mistake in a guide or a tool? Tell us on the <a href="{{ lurl('contact') }}">contact page</a> and it will be corrected.</p>
        </article>
    </div>
@endsection

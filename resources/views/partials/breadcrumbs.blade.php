{{-- Visible breadcrumbs (matching BreadcrumbList schema) --}}
@if (count($seo->breadcrumbs) > 1)
    <nav class="breadcrumbs" aria-label="Breadcrumb">
        <ol>
            @foreach ($seo->breadcrumbs as $crumb)
                @if ($loop->last)
                    <li aria-current="page">{{ $crumb['name'] }}</li>
                @else
                    <li><a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif

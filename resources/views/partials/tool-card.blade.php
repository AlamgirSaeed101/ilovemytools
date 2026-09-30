<a class="tool-card" href="{{ lurl($card['slug']) }}">
    <span class="tool-card__icon">{!! \App\Support\Icon::svg($card['icon'] ?? 'sparkles') !!}</span>
    <span class="tool-card__body">
        <span class="tool-card__name">{{ $card['name'] }}</span>
        <span class="tool-card__desc">{{ $card['tagline'] }}</span>
    </span>
</a>

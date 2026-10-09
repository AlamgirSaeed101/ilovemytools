<?php

// Prints the data scripts/og-images.mjs needs to draw each tool's share image (English text).

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$categories = config('categories');
$out = [];
foreach (config('tools') as $slug => $tool) {
    $category = $categories[$tool['category']] ?? [];
    $out[] = [
        'slug' => $slug,
        'name' => $tool['h1'] ?? $tool['name'],
        'tagline' => $tool['tagline'] ?? '',
        'category' => $category['name'] ?? '',
        'accent' => $category['accent'] ?? '#4f46e5',
        'accent2' => $category['accent2'] ?? '#6366f1',
        'icon' => App\Support\Icon::svg($tool['icon'] ?? 'sparkles'),
        'server' => ! empty($tool['server']),
    ];
}

foreach ($categories as $slug => $category) {
    $count = count(array_filter(config('tools'), fn ($t) => $t['category'] === $slug));
    $out[] = [
        'slug' => 'category-'.$slug,
        'name' => $category['title_short'] ?? ('Free '.$category['name']),
        'tagline' => $count.' free tools: '.($category['subtitle'] ?? ''),
        'category' => $category['name'],
        'accent' => $category['accent'] ?? '#4f46e5',
        'accent2' => $category['accent2'] ?? '#6366f1',
        'icon' => App\Support\Icon::svg($category['icon'] ?? 'sparkles'),
        'server' => false,
    ];
}

echo json_encode(['site' => config('site.name'), 'tools' => $out], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

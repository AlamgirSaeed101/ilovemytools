<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Hand-written guides from config/guides.php (English only: they are not
 * machine-translated, so they exist once, at /guides/{slug}).
 */
class Guides
{
    /** @return Collection<string, array<string, mixed>> */
    public static function all(): Collection
    {
        return collect(config('guides', []))
            ->map(fn (array $guide, string $slug) => $guide + ['slug' => $slug, 'related' => [], 'faqs' => [], 'sources' => []])
            ->sortByDesc('published');
    }

    public static function find(string $slug): ?array
    {
        return self::all()->get($slug);
    }

    /** The guide that explains a tool, if there is one. */
    public static function forTool(string $toolSlug): ?array
    {
        return self::all()->first(fn (array $guide) => $guide['tool'] === $toolSlug);
    }

    /** Short card data for lists and the React app. */
    public static function summary(array $guide): array
    {
        return [
            'slug' => $guide['slug'],
            'title' => $guide['h1'],
            'description' => $guide['description'],
            'tool' => $guide['tool'],
            'published' => $guide['published'],
        ];
    }

    public static function author(): string
    {
        return (string) (config('site.founder')['name'] ?? config('site.name'));
    }
}

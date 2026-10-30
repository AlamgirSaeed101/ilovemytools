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

    /**
     * Other guides to read next: those about the same tool first, then those sharing a related
     * tool, then the newest. Gives every guide internal links from its siblings.
     *
     * @return list<array<string, mixed>> summaries
     */
    public static function relatedTo(array $guide, int $limit = 3): array
    {
        $tools = array_merge([$guide['tool']], $guide['related'] ?? []);

        return self::all()
            ->reject(fn (array $other) => $other['slug'] === $guide['slug'])
            ->sortByDesc(fn (array $other) => match (true) {
                $other['tool'] === $guide['tool'] => 2,
                array_intersect($tools, array_merge([$other['tool']], $other['related'])) !== [] => 1,
                default => 0,
            })
            ->take($limit)
            ->map(fn (array $other) => self::summary($other))
            ->values()->all();
    }

    public static function author(): string
    {
        return (string) (config('site.founder')['name'] ?? config('site.name'));
    }
}

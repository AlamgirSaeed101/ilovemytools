<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Reads config/tools.php and config/categories.php and gives the rest of the
 * app a clean API (lookups, category lists, related tools).
 *
 * Text is returned in the current language: translations from
 * lang/{code}/tools.php and lang/{code}/categories.php are laid over the
 * English originals, field by field, so anything untranslated stays English.
 */
class ToolRegistry
{
    /** Fields that may be translated. Slugs, icons, categories and links never are. */
    private const TOOL_TEXT = ['name', 'title', 'description', 'h1', 'tagline', 'keywords', 'intro', 'steps', 'features', 'content', 'table', 'faqs'];

    private const CATEGORY_TEXT = ['name', 'title', 'description', 'intro', 'content', 'faqs'];

    /** @var array<string, array<string, mixed>> English originals */
    private array $tools;

    /** @var array<string, array<string, mixed>> English originals */
    private array $categories;

    /** @var array<string, array{tools: array, categories: array}> per-language results */
    private array $localized = [];

    public function __construct(array $tools, array $categories)
    {
        foreach ($tools as $slug => $tool) {
            $tools[$slug] = $tool + ['slug' => $slug, 'related' => [], 'faqs' => [], 'steps' => [], 'features' => [], 'content' => [], 'sources' => [], 'popular' => false];
        }
        foreach ($categories as $slug => $category) {
            $categories[$slug] = $category + ['slug' => $slug, 'content' => [], 'faqs' => []];
        }

        $this->tools = $tools;
        $this->categories = $categories;
    }

    /** @return array{tools: array<string, array>, categories: array<string, array>} */
    private function data(): array
    {
        $locale = Locale::current();
        if (isset($this->localized[$locale])) {
            return $this->localized[$locale];
        }

        $toolText = Locale::group('tools', $locale);
        $categoryText = Locale::group('categories', $locale);

        $tools = [];
        foreach ($this->tools as $slug => $tool) {
            $tools[$slug] = self::overlay($tool, $toolText[$slug] ?? [], self::TOOL_TEXT);
        }
        $categories = [];
        foreach ($this->categories as $slug => $category) {
            $categories[$slug] = self::overlay($category, $categoryText[$slug] ?? [], self::CATEGORY_TEXT);
        }

        return $this->localized[$locale] = ['tools' => $tools, 'categories' => $categories];
    }

    private static function overlay(array $original, array $translation, array $fields): array
    {
        foreach ($fields as $field) {
            $value = $translation[$field] ?? null;
            // Only use a translation that has the same shape as the original.
            if ($value !== null && $value !== '' && $value !== [] && gettype($value) === gettype($original[$field] ?? $value)) {
                $original[$field] = $value;
            }
        }

        return $original;
    }

    /** @return Collection<string, array<string, mixed>> */
    public function all(): Collection
    {
        return collect($this->data()['tools']);
    }

    public function slugs(): array
    {
        return array_keys($this->tools);
    }

    public function find(string $slug): ?array
    {
        return $this->data()['tools'][$slug] ?? null;
    }

    /** @return Collection<string, array<string, mixed>> */
    public function popular(): Collection
    {
        return $this->all()->filter(fn (array $tool) => $tool['popular']);
    }

    /** @return Collection<string, array<string, mixed>> */
    public function categories(): Collection
    {
        return collect($this->data()['categories']);
    }

    public function category(string $slug): ?array
    {
        return $this->data()['categories'][$slug] ?? null;
    }

    /** @return Collection<string, array<string, mixed>> */
    public function inCategory(string $categorySlug): Collection
    {
        return $this->all()->filter(fn (array $tool) => $tool['category'] === $categorySlug);
    }

    /**
     * Related tools for internal linking: the hand-picked ones first, then
     * other tools from the same category, never the tool itself.
     *
     * @return Collection<string, array<string, mixed>>
     */
    public function related(array $tool, int $limit = 4): Collection
    {
        $tools = $this->data()['tools'];
        $slugs = collect($tool['related'])
            ->merge($this->inCategory($tool['category'])->keys())
            ->merge($this->popular()->keys())
            ->reject(fn (string $slug) => $slug === $tool['slug'])
            ->unique()
            ->filter(fn (string $slug) => isset($tools[$slug]))
            ->take($limit);

        return $slugs->mapWithKeys(fn (string $slug) => [$slug => $tools[$slug]]);
    }
}

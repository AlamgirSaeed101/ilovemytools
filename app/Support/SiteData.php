<?php

namespace App\Support;

/**
 * Builds the JSON payloads the React front end consumes, both through the
 * /api endpoints and embedded in the first HTML response (so the first page
 * renders without an extra request).
 */
class SiteData
{
    /** Legal / info pages: [label, meta description, search title (optional)] (English; translated with Locale::t). */
    public const PAGES = [
        'about' => ['About Us', 'Learn about {name}: a free collection of fast, private online tools for PDFs, images, text and maths that run in your browser with no sign up.', 'About Us - Free, Private Browser Tools'],
        'contact' => ['Contact Us', 'Contact the {name} team to report a bug, suggest a new free tool or ask a question. Email us and we usually reply within two business days.', 'Contact Us - Report a Bug or Suggest a Tool'],
        'privacy' => ['Privacy Policy', 'How {name} handles your data, cookies and advertising. Files and text you use in our tools are processed in your browser.'],
        'terms' => ['Terms of Use', 'The terms of use for {name}: free online tools for personal and commercial use, provided as is. What you can and cannot do on the site.'],
    ];

    /** URL path of each info page. */
    public const PAGE_PATHS = ['about' => '/about', 'contact' => '/contact', 'privacy' => '/privacy-policy', 'terms' => '/terms'];

    /** Date shown as "Last updated" on the privacy policy and terms. */
    public const LEGAL_UPDATED = '2026-09-29';

    public function __construct(private ToolRegistry $registry)
    {
    }

    /** @return array{0: string, 1: string, 2: string} [search title, meta description, short label] */
    public static function pageMeta(string $page): array
    {
        [$label, $description] = self::PAGES[$page];
        $title = self::PAGES[$page][2] ?? $label;

        return [Locale::t($title), Locale::t($description, ['name' => (string) config('site.name')]), Locale::t($label)];
    }

    public static function tagline(): string
    {
        return (string) (Locale::group('site')['tagline'] ?? config('site.tagline'));
    }

    public static function description(): string
    {
        return (string) (Locale::group('site')['description'] ?? config('site.description'));
    }

    public function site(): array
    {
        $locale = Locale::current();

        return [
            'name' => (string) config('site.name'),
            'tagline' => self::tagline(),
            'description' => self::description(),
            'locale' => $locale,
            'dir' => Locale::dir($locale),
            'defaultLocale' => Locale::default(),
            // Languages search engines may index (config locales.indexable); the client mirrors Seo's rules.
            'indexable' => Locale::indexable(),
            'prefix' => Locale::prefix($locale),
            'locales' => collect(Locale::all())->map(fn (array $l, string $code) => [
                'code' => $code,
                'name' => $l['name'],
                'native' => $l['native'],
                'dir' => $l['dir'],
                'hreflang' => Locale::hreflang($code),
            ])->values()->all(),
            'ui' => (object) Locale::ui($locale),
            'contactEmail' => (string) config('site.contact_email'),
            'url' => Seo::absoluteUrl('/'),
            'legalUpdated' => self::LEGAL_UPDATED,
            'homeFaqs' => HomeFaq::all(),
            'guides' => Guides::all()->map(fn (array $g) => Guides::summary($g))->values()->all(),
            'founded' => (string) config('site.founded'),
            'productHunt' => (string) config('site.product_hunt'),
            'linkedin' => (string) config('site.linkedin'),
            'badges' => array_values(config('site.badges', [])),
            'founder' => (string) (config('site.founder')['name'] ?? ''),
            'ads' => [
                'client' => Ads::liveClient(),
                'placeholders' => Ads::showPlaceholders(),
                'slots' => array_map('strval', (array) config('site.ads.slots', [])),
                'adblockNotice' => (bool) config('site.ads.adblock_notice'),
            ],
            'meta' => [
                'home' => $this->meta(self::tagline(), self::description()),
            ] + collect(array_keys(self::PAGES))->mapWithKeys(fn ($page) => [
                $page => $this->meta(...array_slice(self::pageMeta($page), 0, 2)),
            ])->all(),
            'categories' => $this->registry->categories()->map(fn (array $category, string $slug) => [
                'slug' => $slug,
                'name' => $category['name'],
                'icon' => $category['icon'] ?? 'sparkles',
                'accent' => $category['accent'] ?? '#4f46e5',
                'accent2' => $category['accent2'] ?? ($category['accent'] ?? '#4f46e5'),
                'short' => $category['short'] ?? $category['name'],
                'subtitle' => $category['subtitle'] ?? '',
                'intro' => $category['intro'] ?? '',
                'tools' => $this->registry->inCategory($slug)->keys()->all(),
            ])->values()->all(),
            'tools' => $this->registry->all()->map(fn (array $tool) => $this->summary($tool))->values()->all(),
        ];
    }

    public function tool(string $slug): ?array
    {
        $tool = $this->registry->find($slug);
        if ($tool === null) {
            return null;
        }

        return [
            'slug' => $tool['slug'],
            'name' => $tool['name'],
            'category' => $tool['category'],
            'icon' => $tool['icon'] ?? 'sparkles',
            'h1' => $tool['h1'],
            'tagline' => $tool['tagline'],
            'intro' => $tool['intro'] ?? '',
            'steps' => array_values($tool['steps']),
            'features' => array_values($tool['features']),
            'content' => array_values($tool['content']),
            'table' => $tool['table'] ?? null,
            'faqs' => array_values($tool['faqs']),
            'sources' => array_values($tool['sources'] ?? []),
            'server' => (bool) ($tool['server'] ?? false),
            'updated' => $tool['updated'] ?? null,
            'related' => $this->registry->related($tool)->keys()->all(),
            'guides' => $this->guidesFor($tool['slug']),
            'panel' => self::panelHeight($tool['slug']),
            'meta' => $this->meta($tool['title'], $tool['description']),
        ];
    }

    /**
     * Rendered height of the tool's panel on a phone (sm) and a desktop (lg), measured by
     * scripts/measure-panels.mjs. The page reserves it so nothing jumps when the tool loads.
     *
     * @return array{sm: int, lg: int}|null
     */
    public static function panelHeight(string $slug): ?array
    {
        static $heights = null;
        $heights ??= json_decode((string) @file_get_contents(resource_path('data/tool-panels.json')), true) ?: [];
        $panel = $heights[$slug] ?? null;

        return isset($panel['sm'], $panel['lg']) ? ['sm' => (int) $panel['sm'], 'lg' => (int) $panel['lg']] : null;
    }

    /**
     * The hand-written guides about a tool (its own guide first, then guides that list it as
     * related), so tool pages link to the longer articles. Guides are English only, so
     * every language links the English guide.
     *
     * @return list<array{slug: string, title: string, description: string}>
     */
    public function guidesFor(string $slug): array
    {
        $guides = collect(config('guides', []));
        $own = $guides->filter(fn (array $g) => ($g['tool'] ?? null) === $slug);
        $mentions = $guides->filter(fn (array $g) => ($g['tool'] ?? null) !== $slug && in_array($slug, $g['related'] ?? [], true));

        return $own->union($mentions)->take(2)
            ->map(fn (array $g, string $key) => ['slug' => $key, 'title' => $g['h1'] ?? $g['title'], 'description' => $g['description']])
            ->values()->all();
    }

    public function category(string $slug): ?array
    {
        $category = $this->registry->category($slug);
        if ($category === null) {
            return null;
        }

        return [
            'slug' => $slug,
            'name' => $category['name'],
            'icon' => $category['icon'] ?? 'sparkles',
            'accent' => $category['accent'] ?? '#4f46e5',
                'accent2' => $category['accent2'] ?? ($category['accent'] ?? '#4f46e5'),
                'short' => $category['short'] ?? $category['name'],
                'subtitle' => $category['subtitle'] ?? '',
            'intro' => $category['intro'] ?? '',
            'content' => array_values($category['content'] ?? []),
            'faqs' => array_values($category['faqs'] ?? []),
            'tools' => $this->registry->inCategory($slug)->keys()->all(),
            'meta' => $this->meta($category['title'], $category['description']),
        ];
    }

    private function summary(array $tool): array
    {
        return [
            'slug' => $tool['slug'],
            'name' => $tool['name'],
            'category' => $tool['category'],
            'icon' => $tool['icon'] ?? 'sparkles',
            'tagline' => $tool['tagline'] ?? '',
            'description' => $tool['description'] ?? '',
            'keywords' => array_values($tool['keywords'] ?? []),
            'popular' => (bool) $tool['popular'],
        ];
    }

    private function meta(string $title, string $description): array
    {
        return ['title' => Seo::fullTitle($title), 'description' => Seo::limit($description, 160)];
    }
}

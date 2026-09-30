<?php

namespace App\Support;

/**
 * Builds the JSON payloads the React front end consumes, both through the
 * /api endpoints and embedded in the first HTML response (so the first page
 * renders without an extra request).
 */
class SiteData
{
    /** Legal / info pages: [title, meta description] (English; translated with Locale::t). */
    public const PAGES = [
        'about' => ['About Us', 'Learn about {name}: a free collection of fast, private online tools for PDFs, images, text and maths that run in your browser with no sign up.'],
        'contact' => ['Contact Us', 'Contact the {name} team to report a bug, suggest a new free tool or ask a question. Email us and we usually reply within two business days.'],
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

    public static function pageMeta(string $page): array
    {
        [$title, $description] = self::PAGES[$page];

        return [Locale::t($title), Locale::t($description, ['name' => (string) config('site.name')])];
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
            'ads' => [
                'client' => Ads::liveClient(),
                'placeholders' => Ads::showPlaceholders(),
                'slots' => array_map('strval', (array) config('site.ads.slots', [])),
            ],
            'meta' => [
                'home' => $this->meta(self::tagline(), self::description()),
            ] + collect(array_keys(self::PAGES))->mapWithKeys(fn ($page) => [
                $page => $this->meta(...self::pageMeta($page)),
            ])->all(),
            'categories' => $this->registry->categories()->map(fn (array $category, string $slug) => [
                'slug' => $slug,
                'name' => $category['name'],
                'icon' => $category['icon'] ?? 'sparkles',
                'accent' => $category['accent'] ?? '#4f46e5',
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
            'updated' => $tool['updated'] ?? null,
            'related' => $this->registry->related($tool)->keys()->all(),
            'meta' => $this->meta($tool['title'], $tool['description']),
        ];
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
            'keywords' => array_values($tool['keywords'] ?? []),
            'popular' => (bool) $tool['popular'],
        ];
    }

    private function meta(string $title, string $description): array
    {
        return ['title' => Seo::fullTitle($title), 'description' => Seo::limit($description, 160)];
    }
}

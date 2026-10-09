<?php

namespace App\Support;

/**
 * Builds everything that goes into <head> for SEO: title, meta description,
 * canonical URL, robots, Open Graph, Twitter card and JSON-LD structured data.
 *
 * Controllers create one of these and pass it to the view as $seo.
 */
class Seo
{
    public string $title;

    public string $description;

    public string $canonical;

    public string $robots = 'index, follow, max-image-preview:large';

    public string $ogType = 'website';

    public string $image;

    /** @var array<int, array<string, mixed>> */
    public array $schemas = [];

    /** @var array<int, array{name: string, url: string}> */
    public array $breadcrumbs = [];

    /** Logical path of this page (without the language prefix), used for hreflang links. */
    public ?string $path;

    public function __construct(string $title, string $description, ?string $path = null)
    {
        $this->path = $path ?? self::logicalPath();
        $this->title = self::fullTitle($title);
        $this->description = self::limit($description, 160);
        $this->canonical = Locale::url($this->path);
        $this->image = self::absoluteUrl((string) config('site.og_image'));

        $this->schemas[] = $this->organizationSchema();
        $this->schemas[] = $this->websiteSchema();
    }

    public static function make(string $title, string $description, ?string $path = null): self
    {
        return new self($title, $description, $path);
    }

    /** The current request path without its language prefix ("es/about" -> "/about"). */
    public static function logicalPath(): string
    {
        $path = '/'.ltrim(request()->path(), '/');
        $prefix = Locale::prefix();
        if ($prefix !== '' && ($path === $prefix || str_starts_with($path, $prefix.'/'))) {
            $path = substr($path, strlen($prefix)) ?: '/';
        }

        return $path;
    }

    /**
     * hreflang links: the same page in every language, plus x-default (English).
     *
     * @return array<int, array{hreflang: string, href: string}>
     */
    public function alternates(): array
    {
        if ($this->robots !== 'index, follow, max-image-preview:large' || $this->path === null) {
            return [];
        }
        $links = [];
        foreach (Locale::codes() as $code) {
            $links[] = ['hreflang' => Locale::hreflang($code), 'href' => Locale::url($this->path, $code)];
        }
        $links[] = ['hreflang' => 'x-default', 'href' => Locale::url($this->path, Locale::default())];

        return $links;
    }

    public function noindex(): self
    {
        $this->robots = 'noindex, follow';

        return $this;
    }

    public function addSchema(array $schema): self
    {
        $this->schemas[] = $schema;

        return $this;
    }

    /** @param array<int, array{0: string, 1: string}> $items [name, path] pairs, Home is added first */
    public function breadcrumbs(array $items): self
    {
        $this->breadcrumbs = [['name' => Locale::t('Home'), 'url' => Locale::url('/')]];
        foreach ($items as [$name, $path]) {
            $this->breadcrumbs[] = ['name' => $name, 'url' => Locale::url($path)];
        }

        $this->schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($this->breadcrumbs)->values()->map(fn ($crumb, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'],
            ])->all(),
        ];

        return $this;
    }

    /** @param array<int, array{q: string, a: string}> $faqs */
    public function faqs(array $faqs): self
    {
        if ($faqs === []) {
            return $this;
        }

        $this->schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
            ], $faqs),
        ];

        return $this;
    }

    public function tool(array $tool): self
    {
        $this->image = $this->toolImage($tool['slug'] ?? '');

        $this->schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => $tool['name'],
            'url' => $this->canonical,
            'description' => $tool['description'],
            'applicationCategory' => $tool['category'] === 'developer-tools' ? 'DeveloperApplication' : 'UtilitiesApplication',
            'operatingSystem' => 'Any',
            'browserRequirements' => 'Requires JavaScript. Works in all modern browsers.',
            'isAccessibleForFree' => true,
            'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
            'featureList' => implode(', ', $tool['features']),
            'dateModified' => $tool['updated'] ?? null,
            'inLanguage' => Locale::hreflang(Locale::current()),
            'image' => $this->toolImage($tool['slug'] ?? ''),
            'author' => ['@id' => self::absoluteUrl('/').'#organization'],
            'publisher' => ['@id' => self::absoluteUrl('/').'#organization'],
        ];

        // The page itself, with the parts a voice assistant can read aloud.
        $this->schemas[] = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $this->title,
            'url' => $this->canonical,
            'description' => $tool['description'],
            'inLanguage' => Locale::hreflang(Locale::current()),
            'dateModified' => $tool['updated'] ?? null,
            'isPartOf' => ['@id' => self::absoluteUrl('/').'#website'],
            'publisher' => ['@id' => self::absoluteUrl('/').'#organization'],
            'primaryImageOfPage' => $this->image,
            'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.tool-intro']],
            'citation' => array_map(fn ($source) => ['@type' => 'CreativeWork', 'name' => $source['title'], 'url' => $source['url']], $tool['sources'] ?? []) ?: null,
        ], fn ($value) => $value !== null);

        // "How to use" steps, which answer engines can quote as a list.
        if (! empty($tool['steps'])) {
            $this->schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'HowTo',
                'name' => Locale::t('How to use the {name} tool', ['name' => $tool['name']]),
                'description' => $tool['tagline'] ?? $tool['description'],
                'tool' => ['@type' => 'HowToTool', 'name' => $tool['name']],
                'totalTime' => 'PT1M',
                'step' => array_map(fn ($text, $i) => [
                    '@type' => 'HowToStep',
                    'position' => $i + 1,
                    'name' => $text,
                    'text' => $text,
                    'url' => $this->canonical.'#how-to',
                ], array_values($tool['steps']), array_keys(array_values($tool['steps']))),
            ];
        }

        return $this;
    }

    /** A hand-written guide: Article schema with a named author. */
    public function article(array $guide, string $author): self
    {
        $this->schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $guide['h1'],
            'description' => $guide['description'],
            'url' => $this->canonical,
            'image' => $this->image,
            'inLanguage' => 'en',
            'datePublished' => $guide['published'],
            'dateModified' => $guide['updated'],
            'author' => ['@type' => 'Person', 'name' => $author, 'url' => self::absoluteUrl('/about')],
            'publisher' => ['@id' => self::absoluteUrl('/').'#organization'],
            'mainEntityOfPage' => $this->canonical,
            'citation' => array_map(fn ($s) => ['@type' => 'CreativeWork', 'name' => $s['title'], 'url' => $s['url']], $guide['sources'] ?? []),
        ];

        return $this;
    }

    /** The About page describes the organization behind the site. */
    public function about(): self
    {
        $this->schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'AboutPage',
            'name' => $this->title,
            'url' => $this->canonical,
            'inLanguage' => Locale::hreflang(Locale::current()),
            'isPartOf' => ['@id' => self::absoluteUrl('/').'#website'],
            'mainEntity' => ['@id' => self::absoluteUrl('/').'#organization'],
        ];

        return $this;
    }

    /** Use public/images/og/{name}.jpg as the share image when it exists. */
    public function shareImage(string $name): self
    {
        $this->image = $this->toolImage($name);

        return $this;
    }

    /** A tool's own 1200x630 share image, or the default one. */
    private function toolImage(string $slug): string
    {
        $path = '/images/og/'.$slug.'.jpg';

        return self::absoluteUrl($slug !== '' && is_file(public_path($path)) ? $path : (string) config('site.og_image'));
    }

    /** JSON-LD safe for inline <script>: "</script>" can never break out. */
    public function jsonLd(array $schema): string
    {
        return json_encode(
            $schema,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_PRETTY_PRINT
        ) ?: '{}';
    }

    public static function absoluteUrl(string $path): string
    {
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $base = rtrim((string) config('app.url'), '/');
        $path = '/'.ltrim($path, '/');

        return $path === '/' ? $base.'/' : $base.$path;
    }

    /** Append the brand only when the whole title still fits in the ~60 characters Google shows. */
    public static function fullTitle(string $title): string
    {
        $brand = (string) config('site.name');
        if ($brand === '' || str_contains($title, $brand)) {
            return $title;
        }

        $withBrand = $title.' | '.$brand;

        return mb_strlen($withBrand) <= 60 ? $withBrand : $title;
    }

    public static function limit(string $text, int $max): string
    {
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);
        if (mb_strlen($text) <= $max) {
            return $text;
        }

        $cut = mb_substr($text, 0, $max - 1);
        $space = mb_strrpos($cut, ' ');

        return rtrim($space !== false ? mb_substr($cut, 0, $space) : $cut, ' ,.;:-').'…';
    }

    private function organizationSchema(): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => self::absoluteUrl('/').'#organization',
            'name' => config('site.name'),
            'url' => self::absoluteUrl('/'),
            'logo' => self::absoluteUrl('/images/logo-512.png'),
            'description' => Locale::group('site')['description'] ?? config('site.description'),
            'email' => config('site.contact_email'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer support',
                'email' => config('site.contact_email'),
                'availableLanguage' => array_values(array_map(fn ($l) => $l['name'], Locale::all())),
            ],
            'foundingDate' => config('site.founded'),
            'founder' => ($founder = config('site.founder')) ? array_filter(['@type' => 'Person', 'name' => $founder['name'] ?? null, 'url' => $founder['url'] ?? null]) : null,
            'knowsAbout' => ['PDF', 'Image compression', 'Image conversion', 'Word count', 'Readability', 'QR codes', 'Mortgage calculation', 'JSON', 'SEO'],
            'sameAs' => array_values(array_unique(array_filter([
                ...(array) config('site.same_as', []),
                config('site.twitter_handle') ? 'https://x.com/'.ltrim((string) config('site.twitter_handle'), '@') : null,
            ]))),
        ], fn ($value) => $value !== [] && $value !== '' && $value !== null);
    }

    private function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => self::absoluteUrl('/').'#website',
            'name' => config('site.name'),
            'url' => self::absoluteUrl('/'),
            'description' => Locale::group('site')['description'] ?? config('site.description'),
            'inLanguage' => Locale::hreflang(Locale::current()),
            'publisher' => ['@id' => self::absoluteUrl('/').'#organization'],
        ];
    }
}

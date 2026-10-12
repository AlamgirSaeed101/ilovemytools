<?php

namespace App\Http\Controllers;

use App\Support\HomeFaq;
use App\Support\Locale;
use App\Support\Seo;
use App\Support\SiteData;
use App\Support\ToolRegistry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Every page is the React app. Laravel still renders, per URL:
 *   - the full SEO <head> (title, description, canonical, Open Graph, JSON-LD)
 *   - a plain-HTML copy of the page content for crawlers and no-JS visitors
 *   - the page data as embedded JSON, so React renders instantly
 */
class PageController extends Controller
{
    public function __construct(private ToolRegistry $registry, private SiteData $data)
    {
    }

    public function home(): Response
    {
        $seo = Seo::make(SiteData::tagline(), SiteData::description(), '/')
            ->addSchema([
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'name' => Locale::t('Free online tools'),
                'itemListElement' => $this->registry->all()->values()->map(fn ($tool, $i) => [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $tool['name'],
                    'url' => Locale::url($tool['slug']),
                ])->all(),
            ])
            ->faqs(HomeFaq::all());

        return $this->render('home', $seo, 'pages.home', [
            'categories' => $this->registry->categories(),
            'popular' => $this->registry->popular(),
        ]);
    }

    public function tool(Request $request, string $tool): Response
    {
        $data = $this->registry->find($tool);
        if ($data === null) {
            return $this->notFound(request());
        }

        $category = $this->registry->category($data['category']);

        $seo = Seo::make($data['title'], $data['description'], $data['slug'])
            ->breadcrumbs([
                [$category['name'] ?? Locale::t('Tools'), 'category/'.$data['category']],
                [$data['name'], $data['slug']],
            ])
            ->tool($data)
            ->faqs($data['faqs']);

        // Pages must be identical for every visitor (the site sits behind a caching firewall),
        // so the "What Is My IP" tool fetches the IP from /api/ip instead of it being embedded here.
        $pageData = $this->data->tool($tool);

        return $this->render('tool', $seo, 'pages.tool', [
            'tool' => $data,
            'category' => $category,
            'related' => $this->registry->related($data),
            'guides' => $pageData['guides'] ?? [],
        ], $tool, $pageData);
    }

    public function category(string $category): Response
    {
        $data = $this->registry->category($category);
        if ($data === null) {
            return $this->notFound(request());
        }

        $tools = $this->registry->inCategory($category);
        $path = 'category/'.$category;

        $seo = Seo::make($data['title'], $data['description'], $path)
            ->breadcrumbs([[$data['name'], $path]])
            ->shareImage('category-'.$category)
            ->faqs($data['faqs'] ?? [])
            ->addSchema([
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $data['name'],
                'description' => $data['description'],
                'url' => Locale::url($path),
                'hasPart' => $tools->values()->map(fn ($tool) => [
                    '@type' => 'WebApplication',
                    'name' => $tool['name'],
                    'url' => Locale::url($tool['slug']),
                ])->all(),
            ]);

        return $this->render('category', $seo, 'pages.category', [
            'category' => $data,
            'tools' => $tools,
            'otherCategories' => $this->registry->categories()->except($category),
        ], $category, $this->data->category($category));
    }

    public function about(): Response
    {
        return $this->info('about');
    }

    public function contact(): Response
    {
        return $this->info('contact');
    }

    public function privacy(): Response
    {
        return $this->info('privacy');
    }

    public function terms(): Response
    {
        return $this->info('terms');
    }

    public function notFound(Request $request): Response
    {
        // Unknown URLs have no route middleware, so take the language from the first segment.
        $first = (string) $request->segment(1);
        if ($request->route()?->getName() === null || ! Locale::isSupported(app()->getLocale())) {
            app()->setLocale(Locale::isSupported($first) ? $first : Locale::default());
        }

        return response(view('errors.404'), 404);
    }

    private function info(string $page): Response
    {
        [$title, $description, $label] = SiteData::pageMeta($page);
        $path = SiteData::PAGE_PATHS[$page];
        $seo = Seo::make($title, $description, $path)->breadcrumbs([[$label, $path]]);
        if ($page === 'about') {
            $seo->about();
        }

        return $this->render($page, $seo, 'pages.'.$page, ['pageTitle' => $label]);
    }

    /**
     * Pages are the same for every visitor (no cookies or sessions), so the
     * firewall (Sucuri) may cache them for a day - each deploy clears it - and
     * browsers for 10 minutes (deploys keep the previous build's assets).
     */
    private const PAGE_CACHE = 'public, max-age=600, s-maxage=86400';

    private function render(string $type, Seo $seo, string $view, array $viewData, ?string $slug = null, ?array $pageData = null): Response
    {
        $boot = [
            'site' => $this->data->site(),
            'page' => ['type' => $type, 'slug' => $slug, 'data' => $pageData],
        ];

        return response(view($view, $viewData + ['seo' => $seo, 'boot' => $boot]))->header('Cache-Control', self::PAGE_CACHE);
    }
}

<?php

namespace App\Http\Controllers;

use App\Support\Guides;
use App\Support\Locale;
use App\Support\Seo;
use App\Support\SiteData;
use App\Support\ToolRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * /guides and /guides/{slug}: hand-written English articles. They have no
 * language versions, so no hreflang links are output for them.
 */
class GuideController extends Controller
{
    private const PAGE_CACHE = 'public, max-age=600, s-maxage=86400';

    public function __construct(private ToolRegistry $registry, private SiteData $data)
    {
    }

    public function index(): Response
    {
        $seo = Seo::make('Guides - How to Get More Out of Free Online Tools', 'Practical, step-by-step guides on PDFs, images and writing: how to compress files for email, which image format to use, how many words fit on a page and more.', '/guides')
            ->breadcrumbs([['Guides', '/guides']]);
        // English only: no hreflang, and the language links go to each language's home page.
        $seo->path = null;
        $seo->path = null; // English only: no hreflang alternates

        return $this->render('guides', $seo, 'pages.guides', ['guides' => Guides::all()]);
    }

    public function show(string $guide): Response
    {
        $data = Guides::find($guide);
        abort_if($data === null, 404);

        $path = '/guides/'.$guide;
        $seo = Seo::make($data['title'], $data['description'], $path)
            ->breadcrumbs([['Guides', '/guides'], [$data['h1'], $path]])
            ->shareImage($data['tool'])
            ->faqs($data['faqs'])
            ->article($data, Guides::author())
            ->speakable(['h1', '.guide-article .lead']);
        $seo->ogType = 'article';
        $seo->path = null;

        return $this->render('guide', $seo, 'pages.guide', ['guide' => $data, 'tool' => $this->registry->find($data['tool']), 'moreGuides' => Guides::relatedTo($data)], $guide, $this->payload($data));
    }

    public function api(string $guide): JsonResponse
    {
        $data = Guides::find($guide);
        abort_if($data === null, 404);

        return response()->json($this->payload($data));
    }

    private function payload(array $guide): array
    {
        $tool = $this->registry->find($guide['tool']);

        return [
            'slug' => $guide['slug'],
            'title' => $guide['h1'],
            'meta' => ['title' => Seo::fullTitle($guide['title']), 'description' => $guide['description']],
            'intro' => $guide['intro'],
            'author' => Guides::author(),
            'published' => $guide['published'],
            'updated' => $guide['updated'],
            'sections' => $guide['sections'],
            'faqs' => $guide['faqs'],
            'sources' => $guide['sources'],
            'tool' => $tool ? ['slug' => $tool['slug'], 'name' => $tool['name'], 'icon' => $tool['icon'] ?? 'sparkles', 'tagline' => $tool['tagline']] : null,
            'related' => array_values(array_filter($guide['related'], fn ($slug) => $this->registry->find($slug) !== null)),
            'moreGuides' => Guides::relatedTo($guide),
        ];
    }

    private function render(string $type, Seo $seo, string $view, array $viewData, ?string $slug = null, ?array $pageData = null): Response
    {
        $boot = [
            'site' => $this->data->site(),
            'page' => ['type' => $type, 'slug' => $slug, 'data' => $pageData],
        ];

        return response(view($view, $viewData + ['seo' => $seo, 'boot' => $boot, 'registry' => $this->registry]))->header('Cache-Control', self::PAGE_CACHE);
    }
}

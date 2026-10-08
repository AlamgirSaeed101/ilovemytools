<?php

namespace App\Http\Controllers;

use App\Support\Ads;
use App\Support\Locale;
use App\Support\Seo;
use App\Support\ToolRegistry;
use Illuminate\Http\Response;

/**
 * sitemap.xml, robots.txt and ads.txt are generated dynamically so they are
 * always in sync with config/tools.php and your .env settings.
 */
class SeoFilesController extends Controller
{
    public function __construct(private ToolRegistry $registry)
    {
    }

    public function sitemap(): Response
    {
        $latest = $this->registry->all()->pluck('updated')->filter()->max() ?? date('Y-m-d');

        // Logical paths; each is listed once per language.
        $pages = [['/', $latest, '1.0']];
        foreach ($this->registry->all() as $tool) {
            $pages[] = ['/'.$tool['slug'], $tool['updated'] ?? $latest, '0.9'];
        }
        foreach ($this->registry->categories() as $slug => $category) {
            $pages[] = ['/category/'.$slug, $latest, '0.7'];
        }
        foreach (['/about', '/contact', '/privacy-policy', '/terms'] as $page) {
            $pages[] = [$page, $latest, '0.3'];
        }

        $xml = new \XMLWriter;
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->startDocument('1.0', 'UTF-8');
        // Shows the sitemap as a readable table in browsers; search engines ignore it.
        $xml->writePi('xml-stylesheet', 'type="text/xsl" href="/sitemap.xsl"');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xml->writeAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');
        foreach ($pages as [$path, $lastmod, $priority]) {
            foreach (Locale::codes() as $code) {
                $xml->startElement('url');
                $xml->writeElement('loc', Locale::url($path, $code));
                $xml->writeElement('lastmod', $lastmod);
                $xml->writeElement('priority', $priority);
                // Every language version of this page (Google's multilingual sitemap format).
                foreach (Locale::codes() as $alt) {
                    $xml->startElement('xhtml:link');
                    $xml->writeAttribute('rel', 'alternate');
                    $xml->writeAttribute('hreflang', Locale::hreflang($alt));
                    $xml->writeAttribute('href', Locale::url($path, $alt));
                    $xml->endElement();
                }
                $xml->startElement('xhtml:link');
                $xml->writeAttribute('rel', 'alternate');
                $xml->writeAttribute('hreflang', 'x-default');
                $xml->writeAttribute('href', Locale::url($path, Locale::default()));
                $xml->endElement();
                $xml->endElement();
            }
        }
        $xml->endElement();
        $xml->endDocument();

        return response($xml->outputMemory(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * llms.txt (llmstxt.org): a plain Markdown summary that AI assistants and answer
     * engines can read in one request - what the site is, every tool and its URL.
     */
    public function llms(): Response
    {
        $name = (string) config('site.name');
        $lines = [
            "# {$name}",
            '',
            '> '.config('site.description'),
            '',
            "{$name} is a collection of free online tools. Every tool runs entirely in the visitor's browser: files and text are never uploaded, there is no sign up, no daily limit and no watermark.",
            '',
            'Languages: '.collect(Locale::all())->map(fn ($l, $code) => $l['name'].' ('.Locale::url('/', $code).')')->implode(', ').'. Every page exists in each language under the same path with the language prefix.',
        ];

        foreach ($this->registry->categories() as $category) {
            $lines[] = '';
            $lines[] = '## '.$category['name'];
            $lines[] = '';
            foreach ($this->registry->inCategory($category['slug']) as $tool) {
                $lines[] = '- ['.$tool['name'].']('.Seo::absoluteUrl($tool['slug']).'): '.$tool['tagline'];
            }
        }

        $lines[] = '';
        $lines[] = '## About';
        $lines[] = '';
        $lines[] = '- [About]('.Seo::absoluteUrl('about').'): who runs the site and why';
        $lines[] = '- [Privacy policy]('.Seo::absoluteUrl('privacy-policy').'): how data, cookies and advertising are handled';
        $lines[] = '- [Contact]('.Seo::absoluteUrl('contact').'): '.config('site.contact_email');
        $lines[] = '- [Sitemap]('.Seo::absoluteUrl('sitemap.xml').')';

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function robots(): Response
    {
        // Every crawler is welcome: search engines, AI search/answer engines and SEO tools (backlink
        // and DR data). The named groups say so explicitly; each repeats the /api/ rule because a
        // bot that matches a named group ignores the "*" group.
        $bots = ['Googlebot', 'Google-Extended', 'Bingbot', 'Applebot', 'Applebot-Extended', 'DuckDuckBot', 'YandexBot',
            'GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-SearchBot', 'Claude-User', 'PerplexityBot',
            'Perplexity-User', 'CCBot', 'Amazonbot', 'meta-externalagent', 'AhrefsBot', 'SemrushBot', 'MJ12bot', 'DotBot', '*'];
        $groups = [];
        foreach ($bots as $bot) {
            $groups[] = "User-agent: {$bot}\nAllow: /\nDisallow: /api/";
        }
        $lines = app()->environment('production')
            ? [implode("\n\n", $groups), '', 'Sitemap: '.Seo::absoluteUrl('sitemap.xml')]
            // Keep staging / local copies out of Google.
            : ['User-agent: *', 'Disallow: /'];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function ads(): Response
    {
        $client = Ads::client();
        abort_if($client === '', 404);

        // "ca-pub-123" -> "pub-123"
        $publisher = preg_replace('/^ca-/', '', $client);

        return response("google.com, {$publisher}, DIRECT, f08c47fec0942fa0\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}

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

        // Only canonical, indexable URLs: home, tools and categories in each indexable language
        // (config locales.indexable) with hreflang between them, legal pages in English only, then
        // the English guides. Noindex languages and /{lang}/guides/* never appear.
        $localized = [['/', $latest, '1.0']];
        foreach ($this->registry->all() as $tool) {
            $localized[] = ['/'.$tool['slug'], $tool['updated'] ?? $latest, '0.9'];
        }
        foreach ($this->registry->categories() as $slug => $category) {
            $localized[] = ['/category/'.$slug, $latest, '0.7'];
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
        $languages = Locale::indexable();
        foreach ($localized as [$path, $lastmod, $priority]) {
            foreach ($languages as $code) {
                $xml->startElement('url');
                $xml->writeElement('loc', Locale::url($path, $code));
                $xml->writeElement('lastmod', $lastmod);
                $xml->writeElement('priority', $priority);
                // Every indexable language version of this page (Google's multilingual sitemap format).
                foreach ($languages as $alt) {
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
        // Legal and company pages are indexed in English only (see Seo::englishOnly()).
        foreach (['/about', '/contact', '/privacy-policy', '/terms'] as $path) {
            $xml->startElement('url');
            $xml->writeElement('loc', Locale::url($path, Locale::default()));
            $xml->writeElement('lastmod', $latest);
            $xml->writeElement('priority', '0.3');
            $xml->endElement();
        }
        // Guides exist in English only.
        $xml->startElement('url');
        $xml->writeElement('loc', Seo::absoluteUrl('/guides'));
        $xml->writeElement('priority', '0.6');
        $xml->endElement();
        foreach (\App\Support\Guides::all() as $guide) {
            $xml->startElement('url');
            $xml->writeElement('loc', Seo::absoluteUrl('/guides/'.$guide['slug']));
            $xml->writeElement('lastmod', $guide['updated']);
            $xml->writeElement('priority', '0.7');
            $xml->endElement();
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
        $tools = config('tools', []);
        // Same facts as the About page and the listings: one tool count, and the lookup tools named.
        $lookups = collect($tools)->filter(fn ($tool) => ! empty($tool['server']))->pluck('name')->push('What Is My IP')->all();
        $lines = [
            "# {$name}",
            '',
            '> '.config('site.description'),
            '',
            "{$name} is a free website with ".count($tools).' online tools for PDFs, images, text, calculations and developers. File and text tools run entirely in the visitor\'s browser: files and text are never uploaded. There is no sign up, no daily limit and no watermark.',
            '',
            'Lookup tools that need the internet ('.implode(', ', $lookups).') send the address you enter, or read your IP address, through our server; nothing is stored.',
            '',
            'Languages indexed by search engines: '.collect(Locale::indexable())->map(fn ($code) => Locale::all()[$code]['name'].' ('.Locale::url('/', $code).')')->implode(', ').'. Each page exists in these languages under the same path with the language prefix. Guides are in English only.',
        ];

        foreach ($this->registry->categories() as $category) {
            $lines[] = '';
            $lines[] = '## '.$category['name'];
            $lines[] = '';
            foreach ($this->registry->inCategory($category['slug']) as $tool) {
                $lines[] = '- ['.$tool['name'].']('.Seo::absoluteUrl($tool['slug']).'): '.$tool['tagline'].(empty($tool['server']) ? '' : ' (looks the address up through our server)');
            }
        }

        $lines[] = '';
        $lines[] = '## Guides';
        $lines[] = '';
        foreach (\App\Support\Guides::all() as $guide) {
            $lines[] = '- ['.$guide['h1'].']('.Seo::absoluteUrl('guides/'.$guide['slug']).'): '.$guide['description'];
        }

        $founder = config('site.founder');
        $lines[] = '';
        $lines[] = '## Facts';
        $lines[] = '';
        $lines[] = "- Name: {$name} (".Seo::absoluteUrl('').')';
        $lines[] = '- Founded: '.config('site.founded').', in Islamabad, Pakistan';
        $lines[] = '- Founder: '.$founder['name'].' ('.$founder['url'].')';
        $lines[] = '- Tools: '.count($tools).' free online tools, no sign up, ad-supported';
        $lines[] = '- Guides: '.\App\Support\Guides::all()->count().', in English';

        $lines[] = '';
        $lines[] = '## About';
        $lines[] = '';
        $lines[] = '- [About]('.Seo::absoluteUrl('about').'): who runs the site and why';
        $lines[] = '- [Privacy policy]('.Seo::absoluteUrl('privacy-policy').'): how data, cookies and advertising are handled';
        $lines[] = '- [Contact]('.Seo::absoluteUrl('contact').'): '.config('site.contact_email');
        $lines[] = '- [Sitemap]('.Seo::absoluteUrl('sitemap.xml').')';

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    /** RFC 9116: where to report a security problem. Expires a year ahead, so it never goes stale. */
    public function security(): Response
    {
        $lines = [
            'Contact: mailto:'.config('site.contact_email'),
            'Contact: '.Seo::absoluteUrl('contact'),
            'Expires: '.now()->addYear()->startOfDay()->toIso8601ZuluString(),
            'Preferred-Languages: en',
            'Canonical: '.Seo::absoluteUrl('.well-known/security.txt'),
        ];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function robots(): Response
    {
        // Every crawler is welcome: search engines, AI search/answer engines and SEO tools (backlink
        // and DR data). The named groups say so explicitly; each repeats the /api/ rule because a
        // bot that matches a named group ignores the "*" group.
        $bots = [
            // Search engines (incl. Naver/Daum for the Korean pages)
            'Googlebot', 'GoogleOther', 'Bingbot', 'Applebot', 'DuckDuckBot', 'YandexBot', 'Yeti', 'Daumoa', 'SeznamBot',
            // AI search, assistants and model training
            'Google-Extended', 'Google-CloudVertexBot', 'Applebot-Extended', 'GPTBot', 'OAI-SearchBot', 'ChatGPT-User',
            'ClaudeBot', 'Claude-SearchBot', 'Claude-User', 'Claude-Web', 'anthropic-ai', 'PerplexityBot', 'Perplexity-User',
            'DuckAssistBot', 'MistralAI-User', 'YouBot', 'cohere-ai', 'meta-externalagent', 'Meta-ExternalFetcher',
            'FacebookBot', 'Amazonbot', 'Bytespider', 'PetalBot', 'CCBot', 'Diffbot',
            // SEO tools (backlink and authority data)
            'AhrefsBot', 'AhrefsSiteAudit', 'SemrushBot', 'MJ12bot', 'DotBot',
            '*',
        ];
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

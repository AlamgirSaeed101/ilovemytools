<?php

namespace Tests\Feature;

use App\Support\Guides;
use App\Support\Locale;
use Tests\TestCase;

/**
 * Search Console indexing rules (30 Oct 2026): only canonical, indexable URLs are offered to
 * search engines, hreflang never points at redirects or noindex pages, and guides (English only)
 * are never linked under a language prefix.
 */
class IndexingTest extends TestCase
{
    private function sitemapLocs(): array
    {
        preg_match_all('#<loc>([^<]+)</loc>#', $this->get('/sitemap.xml')->assertOk()->getContent(), $m);

        return $m[1];
    }

    private function hreflangs(string $html): array
    {
        preg_match_all('#<link rel="alternate" hreflang="([^"]+)" href="([^"]+)"#', $html, $m);

        return array_combine($m[1], $m[2]);
    }

    private function noindexLocale(): string
    {
        $noindex = array_values(array_diff(Locale::codes(), Locale::indexable()));
        $this->assertNotEmpty($noindex, 'At least one language is set to noindex in config/locales.php.');

        return $noindex[0];
    }

    public function test_sitemap_lists_only_indexable_canonical_urls(): void
    {
        $locs = $this->sitemapLocs();
        $base = rtrim(config('app.url'), '/');

        $this->assertSame(count($locs), count(array_unique($locs)), 'No duplicate URLs.');
        foreach ($locs as $loc) {
            $this->assertDoesNotMatchRegularExpression('#/[a-z]{2}/guides(/|$)#', $loc, 'Guides only exist in English.');
            $this->assertStringNotContainsString('?', $loc);
        }
        foreach (array_diff(Locale::codes(), Locale::indexable()) as $code) {
            $this->assertEmpty(array_filter($locs, fn ($loc) => $loc === $base.'/'.$code || str_starts_with($loc, $base.'/'.$code.'/')), "No {$code} pages: that language is noindex.");
        }
        foreach (['/about', '/contact', '/privacy-policy', '/terms'] as $legal) {
            $this->assertContains($base.$legal, $locs);
            foreach (Locale::indexable() as $code) {
                if ($code !== Locale::default()) {
                    $this->assertNotContains($base.'/'.$code.$legal, $locs, 'Legal pages are indexed in English only.');
                }
            }
        }
        $this->assertContains($base.'/guides', $locs);
        foreach (Guides::all() as $guide) {
            $this->assertContains($base.'/guides/'.$guide['slug'], $locs);
        }
    }

    public function test_sitemap_hreflang_only_names_indexable_languages(): void
    {
        preg_match_all('#hreflang="([^"]+)"#', $this->get('/sitemap.xml')->getContent(), $m);
        $allowed = array_merge(array_map(fn ($c) => Locale::hreflang($c), Locale::indexable()), ['x-default']);

        $this->assertEqualsCanonicalizing($allowed, array_values(array_unique($m[1])));
    }

    public function test_indexable_pages_have_reciprocal_hreflang_for_indexable_languages_only(): void
    {
        $links = $this->hreflangs($this->get('/word-counter')->assertOk()->getContent());

        $this->assertSame(count(Locale::indexable()) + 1, count($links));
        $this->assertSame(Locale::url('/word-counter', 'en'), $links['x-default']);
        $this->assertArrayNotHasKey(Locale::hreflang($this->noindexLocale()), $links);

        // Each listed alternate is an indexable 200 page that lists the same set back.
        $de = $this->get('/de/word-counter')->assertOk()->getContent();
        $this->assertStringContainsString('content="index, follow', $de);
        $this->assertSame($links, $this->hreflangs($de));
    }

    public function test_noindex_languages_are_noindex_and_have_no_hreflang(): void
    {
        $html = $this->get('/'.$this->noindexLocale().'/word-counter')->assertOk()->getContent();

        $this->assertStringContainsString('<meta name="robots" content="noindex, follow">', $html);
        $this->assertSame([], $this->hreflangs($html));
    }

    public function test_legal_pages_are_indexed_in_english_only(): void
    {
        $en = $this->get('/terms')->assertOk()->getContent();
        $this->assertStringContainsString('content="index, follow', $en);
        $this->assertSame([], $this->hreflangs($en));

        $es = $this->get('/es/privacy-policy')->assertOk()->getContent();
        $this->assertStringContainsString('<meta name="robots" content="noindex, follow">', $es);
        $this->assertSame([], $this->hreflangs($es));
    }

    public function test_language_guide_urls_get_one_permanent_redirect_to_the_english_guide(): void
    {
        $slug = Guides::all()->keys()->first();

        $this->get('/ko/guides/'.$slug)->assertStatus(301)->assertRedirect('/guides/'.$slug);
        $this->get('/es/guides')->assertStatus(301)->assertRedirect('/guides');
    }

    public function test_guide_pages_never_link_to_a_language_guide_url(): void
    {
        $slug = Guides::all()->keys()->first();

        foreach (["/guides/{$slug}", '/guides'] as $path) {
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertDoesNotMatchRegularExpression('#href="[^"]*/[a-z]{2}/guides#', $html, "{$path} links a /{lang}/guides URL.");
            $this->assertSame([], $this->hreflangs($html), "{$path} has no language versions.");
        }
    }

    public function test_every_guide_is_linked_from_its_tool_page_in_every_indexable_language(): void
    {
        foreach (Guides::all() as $guide) {
            foreach (Locale::indexable() as $code) {
                $html = $this->get(Locale::path('/'.$guide['tool'], $code))->assertOk()->getContent();
                $this->assertStringContainsString('/guides/'.$guide['slug'].'"', $html, "{$code} {$guide['tool']} links its guide.");
            }
        }
    }

    public function test_guides_are_linked_from_the_hub_home_page_and_each_other(): void
    {
        $guides = Guides::all();
        $hub = $this->get('/guides')->assertOk()->getContent();
        foreach ($guides as $guide) {
            $this->assertStringContainsString('/guides/'.$guide['slug'].'"', $hub);
        }

        $home = $this->get('/de')->assertOk()->getContent();
        $this->assertStringContainsString('/guides/'.$guides->first()['slug'].'"', $home);

        $first = $guides->first();
        $html = $this->get('/guides/'.$first['slug'])->getContent();
        $this->assertSame(3, preg_match_all('#<a href="[^"]*/guides/(?!'.preg_quote($first['slug'], '#').'")[a-z0-9-]+">#', explode('More guides', $html, 2)[1] ?? ''));
    }

    public function test_guides_link_related_tools_in_their_text_and_the_hub_lists_them(): void
    {
        foreach (Guides::all() as $guide) {
            $html = $this->get('/guides/'.$guide['slug'])->assertOk()->getContent();
            $body = explode('</article>', explode('<article', $html, 2)[1] ?? '', 2)[0];
            $this->assertStringNotContainsString('](/', $body, "{$guide['slug']} shows raw link markup.");
            // Plain in-text links (the "Try the free ..." button has a class, the byline links /about).
            preg_match_all('#<a href="[^"]+/([a-z0-9-]+)">#', $body, $m);
            $tools = array_intersect($m[1], array_keys(config('tools')));
            $this->assertGreaterThanOrEqual(2, count(array_unique($tools)), "{$guide['slug']} links at least 2 tools inside its text.");
        }

        $hub = $this->get('/guides')->getContent();
        $this->assertStringContainsString('"@type": "ItemList"', str_replace('"@type":"ItemList"', '"@type": "ItemList"', $hub));
        $this->assertMatchesRegularExpression('#"numberOfItems":\s*'.Guides::all()->count().'#', $hub);
    }

    public function test_unknown_urls_are_404_noindex_without_a_canonical(): void
    {
        $html = $this->get('/no-such-page-xyz')->assertNotFound()->getContent();

        $this->assertStringContainsString('noindex', $html);
        $this->assertStringNotContainsString('rel="canonical"', $html);
    }

    public function test_security_txt_follows_rfc_9116(): void
    {
        $body = $this->get('/.well-known/security.txt')->assertOk()->assertHeader('Content-Type', 'text/plain; charset=UTF-8')->getContent();

        $this->assertStringContainsString('Contact: mailto:'.config('site.contact_email'), $body);
        $this->assertMatchesRegularExpression('#^Expires: \d{4}-\d\d-\d\dT00:00:00Z$#m', $body);
    }

    public function test_english_about_page_answers_who_what_why_with_faq_schema(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertStringContainsString('at a glance', $html);
        $this->assertStringContainsString('Who makes', $html);
        $this->assertStringContainsString('"@type": "FAQPage"', str_replace('"@type":"FAQPage"', '"@type": "FAQPage"', $html));
        $this->assertStringContainsString('foundingLocation', $html);

        // Translated About pages are noindex and keep their own copy.
        $this->assertStringNotContainsString('at a glance', $this->get('/de/about')->getContent());
    }
}

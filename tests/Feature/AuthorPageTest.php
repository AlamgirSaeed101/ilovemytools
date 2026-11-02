<?php

namespace Tests\Feature;

use App\Support\Guides;
use Tests\TestCase;

/** The founder's author page (/about/m-alamgir-saeed): E-E-A-T for the guides. */
class AuthorPageTest extends TestCase
{
    private const PATH = '/about/m-alamgir-saeed';

    /** @return list<array<string, mixed>> every JSON-LD block on the page */
    private function schemas(string $html): array
    {
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);

        return array_map(fn ($json) => json_decode($json, true), $m[1]);
    }

    public function test_the_author_page_shows_the_founder_and_his_guides(): void
    {
        $founder = config('site.founder');
        $html = $this->get(self::PATH)->assertOk()->getContent();

        $this->assertStringContainsString('<h1>'.e($founder['name']).'</h1>', $html);
        $this->assertStringContainsString('Founder and developer of '.config('site.name'), $html);
        $this->assertStringContainsString('Islamabad, Pakistan', $html);
        foreach (Guides::all() as $guide) {
            $this->assertStringContainsString(url('/guides/'.$guide['slug']).'"', $html);
        }
        foreach ($founder['same_as'] as $profile) {
            $this->assertStringContainsString('href="'.$profile.'"', $html);
        }
        $this->assertStringContainsString('index, follow', $html);
        $this->assertStringNotContainsString('<link rel="alternate" hreflang=', $html);
        $this->assertStringContainsString('<link rel="canonical" href="'.url(self::PATH).'"', $html);
    }

    public function test_the_author_page_has_profile_page_and_person_schema(): void
    {
        $schemas = $this->schemas($this->get(self::PATH)->getContent());

        $profile = collect($schemas)->firstWhere('@type', 'ProfilePage');
        $this->assertNotNull($profile, 'ProfilePage schema is missing.');
        $person = $profile['mainEntity'];
        $this->assertSame('Person', $person['@type']);
        $this->assertSame(config('site.founder.name'), $person['name']);
        $this->assertSame(url(self::PATH), $person['url']);
        $this->assertSame('Founder and developer of '.config('site.name'), $person['jobTitle']);
        $this->assertSame(rtrim(url('/'), '/').'/#organization', $person['worksFor']['@id']);
        $this->assertSame('Islamabad, Pakistan', $person['homeLocation']['name']);
        $this->assertSame(config('site.founder.same_as'), $person['sameAs']);

        $crumbs = collect($schemas)->firstWhere('@type', 'BreadcrumbList')['itemListElement'];
        $this->assertSame([rtrim(url('/'), '/').'/', url('/about'), url(self::PATH)], array_column($crumbs, 'item'));

        // The Organization keeps the founder's external profiles and points at this page.
        $org = collect($schemas)->firstWhere('@type', 'Organization');
        $this->assertSame(url(self::PATH), $org['founder']['url']);
        $this->assertSame(config('site.founder.same_as'), $org['founder']['sameAs']);
    }

    public function test_translated_copies_are_noindex_without_hreflang(): void
    {
        $html = $this->get('/de'.self::PATH)->assertOk()->getContent();

        $this->assertStringContainsString('noindex, follow', $html);
        $this->assertStringNotContainsString('<link rel="alternate" hreflang=', $html);
    }

    public function test_the_sitemap_lists_the_english_author_page_only(): void
    {
        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

        $this->assertStringContainsString('<loc>'.url(self::PATH).'</loc>', $xml);
        $this->assertStringNotContainsString('/de'.self::PATH, $xml);
    }

    public function test_guides_credit_the_author_page(): void
    {
        $guide = Guides::all()->first();
        $html = $this->get('/guides/'.$guide['slug'])->assertOk()->getContent();

        $article = collect($this->schemas($html))->firstWhere('@type', 'Article');
        $this->assertSame(url(self::PATH), $article['author']['url']);
        $this->assertStringContainsString('By <a href="'.url(self::PATH).'" rel="author">', $html);

        $this->assertStringContainsString('href="'.url(self::PATH).'"', $this->get('/about')->getContent());
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Tests should not depend on the compiled frontend assets.
        $this->withoutVite();
    }

    public function test_home_page_renders_with_seo_tags(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('<h1 class="hero__title">Free Online Tools for PDF, Image &amp; Text</h1>', false)
            ->assertSee('<link rel="canonical" href="https://toolzy.test/">', false)
            ->assertSee('<meta name="description"', false)
            ->assertSee('"@type": "WebSite"', false)
            ->assertSee('"@type": "ItemList"', false);

        foreach (array_keys(config('tools')) as $slug) {
            $response->assertSee('href="https://toolzy.test/'.$slug.'"', false);
        }
    }

    public function test_every_tool_page_renders_with_complete_seo(): void
    {
        foreach (config('tools') as $slug => $tool) {
            $response = $this->get('/'.$slug);

            $response->assertOk()
                ->assertSee('<h1 class="tool-header__title">'.e($tool['h1']).'</h1>', false)
                ->assertSee('<link rel="canonical" href="https://toolzy.test/'.$slug.'">', false)
                ->assertSee('<div id="app">', false)
                ->assertSee('"type":"tool","slug":"'.$slug.'"', false)
                ->assertSee('"@type": "WebApplication"', false)
                ->assertSee('"@type": "FAQPage"', false)
                ->assertSee('"@type": "BreadcrumbList"', false)
                ->assertSee('<meta property="og:title"', false)
                ->assertSee('<meta name="robots" content="index, follow', false);

            // Exactly one H1 per page.
            $this->assertSame(1, substr_count($response->getContent(), '<h1'), "$slug should have one <h1>");

            // Every FAQ question is visible on the page (Google requires this for FAQ schema).
            foreach ($tool['faqs'] as $faq) {
                $response->assertSee(e($faq['q']), false);
            }
        }
    }

    public function test_category_pages_render(): void
    {
        foreach (config('categories') as $slug => $category) {
            $this->get('/category/'.$slug)
                ->assertOk()
                ->assertSee('<h1>'.e($category['name']).'</h1>', false)
                ->assertSee('"@type": "CollectionPage"', false);
        }
    }

    public function test_legal_pages_render(): void
    {
        foreach (['/about', '/contact', '/privacy-policy', '/terms'] as $url) {
            $this->get($url)->assertOk()->assertSee('<link rel="canonical" href="https://toolzy.test'.$url.'">', false);
        }

        // AdSense requires these disclosures in the privacy policy.
        $this->get('/privacy-policy')
            ->assertSee('Google')
            ->assertSee('adssettings.google.com', false)
            ->assertSee('aboutads.info', false);
    }

    public function test_unknown_pages_return_404_with_noindex(): void
    {
        $this->get('/this-tool-does-not-exist')
            ->assertNotFound()
            ->assertSee('noindex', false)
            ->assertSee('Page not found');

        $this->get('/category/nope')->assertNotFound();
    }

    public function test_no_ad_markup_when_ads_are_not_configured(): void
    {
        $this->get('/word-counter')
            ->assertDontSee('adsbygoogle', false)
            ->assertSee('"client":""', false);
    }

    public function test_production_shows_real_ads(): void
    {
        $this->app['env'] = 'production';
        config([
            'site.ads.client' => 'ca-pub-1234567890123456',
            'site.ads.slots.below_tool' => '1111',
        ]);

        $this->get('/word-counter')
            ->assertSee('pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1234567890123456', false)
            ->assertSee('"client":"ca-pub-1234567890123456","placeholders":false', false)
            ->assertSee('"below_tool":"1111"', false);
    }

    public function test_production_auto_ads_never_shows_placeholders(): void
    {
        $this->app['env'] = 'production';
        config(['site.ads.client' => 'pub-9876543210987654', 'site.ads.show_placeholders' => true]);

        $html = $this->get('/merge-pdf')->getContent();

        $this->assertStringContainsString('adsbygoogle.js?client=ca-pub-9876543210987654', $html);
        $this->assertStringContainsString('"client":"ca-pub-9876543210987654","placeholders":false', $html);
    }

    public function test_local_shows_ad_placeholders_and_never_loads_google(): void
    {
        $this->app['env'] = 'local';
        config(['site.ads.client' => 'ca-pub-1234567890123456', 'site.ads.show_placeholders' => null]);

        $this->get('/word-counter')
            ->assertDontSee('adsbygoogle', false)
            ->assertSee('"client":"","placeholders":true', false);
    }

    public function test_google_tag_loads_first_in_head_in_production_only(): void
    {
        config(['site.ga4_id' => 'G-GMWZ0PJW1R']);

        $this->app['env'] = 'local';
        $this->get('/')->assertDontSee('googletagmanager.com', false);

        $this->app['env'] = 'production';
        $html = $this->get('/')->getContent();
        $this->assertSame(1, substr_count($html, 'googletagmanager.com/gtag/js?id=G-GMWZ0PJW1R'));
        $this->assertStringContainsString("gtag('config', \"G-GMWZ0PJW1R\");", $html);
        // Immediately after <head>, before anything else.
        $this->assertMatchesRegularExpression('#<head>\s*<script async src="https://www\.googletagmanager\.com/gtag/js\?id=G-GMWZ0PJW1R"#', $html);
    }

    public function test_malformed_adsense_id_is_ignored(): void
    {
        $this->app['env'] = 'production';
        config(['site.ads.client' => 'ca-pub-123 <script>']);

        $this->get('/')->assertDontSee('adsbygoogle.js', false);
        $this->get('/ads.txt')->assertNotFound();
    }

    public function test_security_headers_are_sent(): void
    {
        $this->get('/')->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->getJson('/api/site')->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_pages_set_no_cookies_or_sessions(): void
    {
        $response = $this->get('/word-counter');

        $this->assertSame([], $response->headers->getCookies());
    }

    public function test_page_embeds_boot_data_for_react(): void
    {
        $html = $this->get('/merge-pdf')->getContent();

        $this->assertMatchesRegularExpression('#<script id="boot-data" type="application/json">(.+?)</script>#s', $html);
        preg_match('#<script id="boot-data" type="application/json">(.+?)</script>#s', $html, $m);
        $boot = json_decode($m[1], true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame('tool', $boot['page']['type']);
        $this->assertSame('merge-pdf', $boot['page']['data']['slug']);
        $this->assertCount(count(config('tools')), $boot['site']['tools']);
        $this->assertCount(count(config('categories')), $boot['site']['categories']);
    }

    public function test_ip_tool_page_never_embeds_the_visitor_ip(): void
    {
        // The HTML may be cached by a CDN/firewall, so it must not contain anyone's IP.
        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.9'])
            ->get('/what-is-my-ip')
            ->assertOk()
            ->assertDontSee('203.0.113.9', false);
    }

    public function test_boot_json_cannot_break_out_of_its_script_tag(): void
    {
        config(['site.tagline' => 'Tools </script><script>alert(1)</script>']);

        $html = $this->get('/')->getContent();
        preg_match('#<script id="boot-data" type="application/json">(.+?)</script>#s', $html, $m);

        $this->assertStringNotContainsString('<script>alert(1)', $m[1]);
        $this->assertSame('Tools </script><script>alert(1)</script>', json_decode($m[1], true)['site']['tagline']);
    }
}

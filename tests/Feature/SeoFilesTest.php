<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoFilesTest extends TestCase
{
    public function test_sitemap_lists_every_page(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml, 'sitemap.xml must be valid XML');

        $locs = array_map('strval', $xml->xpath('//*[local-name()="loc"]'));
        $this->assertContains('https://toolzy.test/', $locs);

        foreach (array_keys(config('tools')) as $slug) {
            $this->assertContains('https://toolzy.test/'.$slug, $locs);
        }
        foreach (array_keys(config('categories')) as $slug) {
            $this->assertContains('https://toolzy.test/category/'.$slug, $locs);
        }
    }

    public function test_robots_blocks_everything_outside_production(): void
    {
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /');
    }

    public function test_robots_points_to_sitemap_in_production(): void
    {
        $this->app['env'] = 'production';

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Allow: /')
            ->assertSee('Sitemap: https://toolzy.test/sitemap.xml');
    }

    public function test_ads_txt(): void
    {
        $this->get('/ads.txt')->assertNotFound();

        config(['site.ads.client' => 'ca-pub-1234567890123456']);

        $this->get('/ads.txt')
            ->assertOk()
            ->assertSee('google.com, pub-1234567890123456, DIRECT, f08c47fec0942fa0');
    }

    public function test_ip_endpoint_returns_visitor_ip(): void
    {
        $response = $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.9'])->getJson('/api/ip');

        $response->assertOk()->assertExactJson(['ip' => '203.0.113.9', 'version' => 'IPv4']);
        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
    }
}

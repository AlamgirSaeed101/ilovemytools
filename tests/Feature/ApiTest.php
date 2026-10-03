<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_site_endpoint_lists_categories_and_tools(): void
    {
        $response = $this->getJson('/api/site')->assertOk();

        $response->assertJsonPath('name', config('site.name'))
            ->assertJsonCount(count(config('tools')), 'tools')
            ->assertJsonCount(count(config('categories')), 'categories')
            ->assertJsonStructure([
                'name', 'tagline', 'url', 'contactEmail', 'legalUpdated',
                'ads' => ['client', 'placeholders', 'slots'],
                'meta' => ['home' => ['title', 'description'], 'about', 'contact', 'privacy', 'terms'],
                'categories' => [['slug', 'name', 'icon', 'accent', 'intro', 'tools']],
                'tools' => [['slug', 'name', 'category', 'icon', 'tagline', 'keywords', 'popular']],
            ]);

        // Every tool listed in a category exists in the tool list.
        $slugs = array_column($response->json('tools'), 'slug');
        foreach ($response->json('categories') as $category) {
            foreach ($category['tools'] as $slug) {
                $this->assertContains($slug, $slugs);
            }
        }
    }

    public function test_tool_endpoint_returns_full_content(): void
    {
        foreach (config('tools') as $slug => $tool) {
            $this->getJson('/api/tools/'.$slug)
                ->assertOk()
                ->assertJsonPath('slug', $slug)
                ->assertJsonPath('h1', $tool['h1'])
                ->assertJsonCount(count($tool['faqs']), 'faqs')
                ->assertJsonStructure(['intro', 'steps', 'features', 'content', 'related', 'meta' => ['title', 'description']]);
        }
    }

    public function test_category_endpoint(): void
    {
        $expected = array_keys(array_filter(config('tools'), fn ($tool) => $tool['category'] === 'pdf-tools'));

        $this->getJson('/api/categories/pdf-tools')
            ->assertOk()
            ->assertJsonPath('name', 'PDF Tools')
            ->assertJsonPath('tools', $expected);
    }

    public function test_unknown_items_return_json_404(): void
    {
        $this->getJson('/api/tools/nope')->assertNotFound()->assertJsonPath('message', 'Tool not found.');
        $this->getJson('/api/categories/nope')->assertNotFound()->assertJsonPath('message', 'Category not found.');
    }

    public function test_api_sets_no_cookies(): void
    {
        $this->assertSame([], $this->getJson('/api/site')->headers->getCookies());
    }

    public function test_ip_endpoint_ignores_spoofed_forwarded_header_by_default(): void
    {
        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.9'])
            ->withHeaders(['X-Forwarded-For' => '1.2.3.4'])
            ->getJson('/api/ip')
            ->assertJsonPath('ip', '203.0.113.9');
    }

    public function test_ip_endpoint_unwraps_ipv4_mapped_ipv6(): void
    {
        $this->withServerVariables(['REMOTE_ADDR' => '::ffff:198.51.100.7'])
            ->getJson('/api/ip')
            ->assertExactJson(['ip' => '198.51.100.7', 'version' => 'IPv4']);
    }

    public function test_storage_routes_are_disabled(): void
    {
        $this->assertFalse(app('router')->has('storage.local'));
        $this->put('/storage/evil.txt', ['x' => 1])->assertStatus(405);
    }
}

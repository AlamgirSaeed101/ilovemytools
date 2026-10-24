<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PageCacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_pages_are_served_from_the_saved_copy_in_production(): void
    {
        $this->app['env'] = 'production';

        $first = $this->get('/word-counter');
        $first->assertOk()->assertHeader('X-Page-Cache', 'MISS');

        $second = $this->get('/word-counter');
        $second->assertOk()->assertHeader('X-Page-Cache', 'HIT');
        $this->assertSame($first->getContent(), $second->getContent());
        $this->assertStringContainsString('text/html', (string) $second->headers->get('Content-Type'));
    }

    public function test_query_strings_api_and_missing_pages_are_never_cached(): void
    {
        $this->app['env'] = 'production';

        $this->get('/word-counter?utm_source=x')->assertOk()->assertHeaderMissing('X-Page-Cache');
        $this->get('/no-such-tool-here')->assertNotFound()->assertHeaderMissing('X-Page-Cache');
        $this->get('/no-such-tool-here')->assertNotFound()->assertHeaderMissing('X-Page-Cache');
    }

    public function test_nothing_is_cached_outside_production(): void
    {
        $this->get('/word-counter')->assertOk()->assertHeaderMissing('X-Page-Cache');
        $this->get('/word-counter')->assertOk()->assertHeaderMissing('X-Page-Cache');
    }
}

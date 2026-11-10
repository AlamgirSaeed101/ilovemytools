<?php

namespace Tests\Feature;

use Tests\TestCase;

/** Public pages must be cacheable by the firewall for anonymous visitors (P0-3). */
class EdgeCacheTest extends TestCase
{
    public function test_public_pages_set_no_cookies_and_do_not_vary_on_them(): void
    {
        foreach (['/', '/merge-pdf', '/de/merge-pdf', '/guides', '/category/pdf-tools', '/about'] as $url) {
            $response = $this->get($url)->assertOk();
            $this->assertSame([], $response->headers->getCookies(), $url.' sets a cookie');
            $this->assertStringNotContainsStringIgnoringCase('cookie', (string) $response->headers->get('Vary'), $url);
            $cache = (string) $response->headers->get('Cache-Control');
            $this->assertStringNotContainsString('no-store', $cache, $url);
            $this->assertStringNotContainsString('private', $cache, $url);
            $this->assertStringContainsString('max-age=600', $cache, $url);
        }
    }
}

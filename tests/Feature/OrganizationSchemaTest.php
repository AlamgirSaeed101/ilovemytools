<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrganizationSchemaTest extends TestCase
{
    public function test_organization_lists_brand_profiles_and_only_the_indexed_support_languages(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        $org = collect($m[1])->map(fn ($json) => json_decode($json, true))
            ->first(fn ($schema) => ($schema['@type'] ?? null) === 'Organization');

        $this->assertNotNull($org);
        $this->assertSame(['English', 'German', 'Italian'], $org['contactPoint']['availableLanguage']);
        $this->assertContains('https://www.linkedin.com/company/ilovemytools', $org['sameAs']);
    }
}

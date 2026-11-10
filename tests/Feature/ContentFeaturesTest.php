<?php

namespace Tests\Feature;

use App\Support\Guides;
use Tests\TestCase;

class ContentFeaturesTest extends TestCase
{
    public function test_guides_have_a_table_of_contents_linking_to_each_section(): void
    {
        $guide = Guides::find('how-to-convert-excel-to-pdf');
        $response = $this->get('/guides/how-to-convert-excel-to-pdf')->assertOk();
        $response->assertSee('On this page');
        foreach ($guide['sections'] as $section) {
            $id = Guides::headingId($section['heading']);
            $response->assertSee('href="#'.$id.'"', false)->assertSee('id="'.$id.'"', false);
        }
    }

    public function test_tool_sections_render_their_bullet_lists_in_english_german_and_italian(): void
    {
        foreach (['', '/de', '/it'] as $prefix) {
            $html = $this->get($prefix.'/age-calculator')->assertOk()->getContent();
            $tool = app(\App\Support\ToolRegistry::class);
            $this->assertMatchesRegularExpression('#</p>\s*<ul>\s*<li>#', $html, $prefix ?: 'en');
        }
    }

    public function test_crawlers_get_content_not_a_javascript_warning(): void
    {
        $html = $this->get('/merge-pdf')->assertOk()->getContent();
        $this->assertStringNotContainsString('no-js-notice', $html);
        $this->assertMatchesRegularExpression('#<noscript><p class="notice notice--warn">[^<]*JavaScript#', $html);
    }

    public function test_footer_links_the_author_page(): void
    {
        $this->get('/')->assertSee('href="'.url(Guides::AUTHOR_PATH).'" rel="author"', false);
    }
}

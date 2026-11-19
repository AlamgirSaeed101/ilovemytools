<?php

namespace Tests\Feature;

use Tests\TestCase;

class TrustpilotWidgetTest extends TestCase
{
    public function test_home_footer_has_the_trustpilot_widget_with_a_fallback_link(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $footer = strpos($html, '<footer class="site-footer">');
        $widget = strpos($html, '<div class="trustpilot-widget" data-locale="en-US" data-template-id="56278e9abfbbba0bdcd568bc" data-businessunit-id="6afb15c79898c9d06ed48fd9" data-style-height="52px" data-style-width="100%" style="height:52px">');
        $this->assertNotFalse($footer);
        $this->assertNotFalse($widget);
        $this->assertGreaterThan($footer, $widget);

        $this->assertStringContainsString('<a href="https://www.trustpilot.com/review/ilovemytools.store" target="_blank" rel="noopener">Review us on Trustpilot</a>', $html);
        // The script is loaded later by the React footer, never in the page head.
        $this->assertStringNotContainsString('tp.widget.bootstrap', $html);
    }

    public function test_boot_data_gives_the_react_footer_the_same_widget(): void
    {
        $html = $this->get('/')->getContent();
        preg_match('#<script id="boot-data" type="application/json">(.*?)</script>#s', $html, $m);
        $site = json_decode($m[1], true);
        $tp = $site['site']['trustpilot'] ?? null;

        $this->assertNotNull($tp);
        $this->assertSame('6afb15c79898c9d06ed48fd9', $tp['business_unit_id']);
        $this->assertSame('https://www.trustpilot.com/review/ilovemytools.store', $tp['url']);
    }

    public function test_widget_uses_the_page_language(): void
    {
        $html = $this->get('/es')->assertOk()->getContent();
        $this->assertStringContainsString('data-locale="es-ES"', $html);
    }
}

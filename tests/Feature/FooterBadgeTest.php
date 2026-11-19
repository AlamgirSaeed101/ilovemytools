<?php

namespace Tests\Feature;

use Tests\TestCase;

class FooterBadgeTest extends TestCase
{
    public function test_home_html_carries_the_hype_star_badge_in_the_footer(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $footer = strpos($html, '<footer class="site-footer">');
        $badge = strpos($html, 'class="footer-badge hypestar-badge"');
        $this->assertNotFalse($footer);
        $this->assertNotFalse($badge);
        $this->assertGreaterThan($footer, $badge);

        $this->assertStringContainsString('href="https://hypestar.org/?utm_source=supporter_badge&amp;utm_medium=referral&amp;utm_campaign=hype_star_badge" target="_blank" rel="noopener nofollow"', $html);
        $this->assertStringContainsString('<img src="https://hypestar.org/badges/support-hype-star-auto-v2.svg" width="140" height="24" alt="Featured on Hype Star" loading="lazy">', $html);
    }

    public function test_badge_is_in_the_footer_of_other_pages_too(): void
    {
        $this->assertStringContainsString('hypestar-badge', $this->get('/merge-pdf')->getContent());
    }
}

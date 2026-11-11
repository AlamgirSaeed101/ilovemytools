<?php

namespace Tests\Feature;

use Tests\TestCase;

class FeaturedBannerTest extends TestCase
{
    public function test_home_shows_the_nashemanbot_banner_between_the_introduction_and_the_tools(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $banner = strpos($html, 'class="feature-banner"');
        $this->assertNotFalse($banner);
        $this->assertGreaterThan(strpos($html, 'class="hero__title"'), $banner);
        $this->assertLessThan(strpos($html, 'class="section"'), $banner);

        foreach (['FEATURED WEBSITE', 'Discover NashemanBot', 'Explore NashemanBot on its official website.', 'Visit NashemanBot', 'nashemanbot.io'] as $text) {
            $this->assertStringContainsString($text, $html);
        }
        $this->assertStringContainsString('<a class="feature-banner__button" href="https://nashemanbot.io/" target="_blank" rel="noopener noreferrer">', $html);
    }

    public function test_banner_is_only_on_the_home_page(): void
    {
        $this->assertStringNotContainsString('class="feature-banner"', $this->get('/merge-pdf')->getContent());
    }
}

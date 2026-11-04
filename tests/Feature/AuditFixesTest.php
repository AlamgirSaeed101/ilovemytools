<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/** The priority fixes from the audit of 4 Nov 2026. */
class AuditFixesTest extends TestCase
{
    public function test_adsense_script_and_account_meta_are_in_the_head_in_production(): void
    {
        $this->app['env'] = 'production';
        config(['site.ads.client' => 'ca-pub-1234567890123456']);

        foreach (['/', '/merge-pdf', '/de/merge-pdf', '/guides'] as $url) {
            $head = explode('</head>', $this->get($url)->assertOk()->getContent())[0];
            $this->assertStringContainsString('<meta name="google-adsense-account" content="ca-pub-1234567890123456">', $head);
            $this->assertStringContainsString('adsbygoogle.js?client=ca-pub-1234567890123456', $head);
        }
    }

    public function test_google_ads_never_load_outside_production(): void
    {
        config(['site.ads.client' => 'ca-pub-1234567890123456']);

        $html = $this->get('/')->getContent();
        $this->assertStringNotContainsString('adsbygoogle.js', $html);
        $this->assertStringNotContainsString('google-adsense-account', $html);
    }

    public function test_analytics_skips_automated_browsers(): void
    {
        $this->app['env'] = 'production';
        config(['site.ga4_id' => 'G-TEST12345']);

        $this->assertMatchesRegularExpression('#navigator\.webdriver \|\| /lighthouse\|headless#', $this->get('/')->getContent());
    }

    public function test_only_the_chosen_languages_are_indexed(): void
    {
        $this->assertStringContainsString('content="index, follow', $this->get('/de/merge-pdf')->getContent());
        $this->assertStringContainsString('content="index, follow', $this->get('/it/merge-pdf')->getContent());
        foreach (['es', 'fr', 'pt', 'zh', 'ko', 'pl', 'ur'] as $code) {
            $this->assertStringContainsString('content="noindex, follow"', $this->get("/{$code}/merge-pdf")->assertOk()->getContent(), $code);
        }
        $sitemap = $this->get('/sitemap.xml')->getContent();
        $this->assertStringNotContainsString(url('/es/merge-pdf'), $sitemap);
    }

    public function test_company_pages_keep_their_own_sitemap_dates(): void
    {
        $sitemap = $this->get('/sitemap.xml')->getContent();

        $this->assertMatchesRegularExpression('#<loc>'.preg_quote(url('/terms'), '#').'</loc>\s*<lastmod>2026-09-30</lastmod>#', $sitemap);
    }

    public function test_llms_full_lists_every_tool_with_its_steps(): void
    {
        $body = $this->get('/llms-full.txt')->assertOk()->assertHeader('Content-Type', 'text/plain; charset=UTF-8')->getContent();

        foreach (config('tools') as $slug => $tool) {
            $this->assertStringContainsString('## '.$tool['name'], $body, $slug);
        }
        $this->assertStringContainsString('uses our server for lookups', $body);
    }

    public function test_contact_form_emails_the_site_and_rejects_bad_input(): void
    {
        Mail::fake();

        $this->postJson('/api/contact', ['name' => 'Ann', 'email' => 'ann@example.com', 'message' => 'The tool works well, thanks.'])
            ->assertOk()->assertJson(['status' => 'sent']);
        Mail::assertSent(ContactMessage::class, fn ($m) => $m->hasTo(config('site.contact_email')) && $m->hasReplyTo('ann@example.com'));

        $this->postJson('/api/contact', ['name' => 'Ann', 'email' => 'nope', 'message' => 'short'])->assertStatus(422);
    }

    public function test_top_tools_show_first_hand_results_in_english_only(): void
    {
        $notes = config('tool-notes');
        $this->assertGreaterThanOrEqual(15, count($notes));

        foreach ($notes as $slug => $note) {
            $this->assertArrayHasKey($slug, config('tools'));
            $html = $this->get('/'.$slug)->assertOk()->getContent();
            $this->assertStringContainsString('id="tested"', $html, $slug);
            $this->assertStringContainsString(e($note['paragraphs'][0]), $html, $slug);
        }
        $this->assertStringNotContainsString('id="tested"', $this->get('/de/merge-pdf')->getContent());
    }

    public function test_contact_form_honeypot_sends_nothing(): void
    {
        Mail::fake();

        $this->postJson('/api/contact', ['name' => 'Bot', 'email' => 'b@example.com', 'message' => 'Buy things now please.', 'website' => 'x'])->assertOk();
        Mail::assertNothingSent();
    }
}

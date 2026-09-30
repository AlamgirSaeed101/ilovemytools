<?php

namespace Tests\Feature;

use App\Mail\ConfirmSubscription;
use App\Mail\NewToolsAnnouncement;
use App\Models\Subscriber;
use App\Support\ToolRegistry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_signing_up_stores_a_pending_subscriber_and_sends_a_confirmation(): void
    {
        Mail::fake();

        $this->postJson('/api/newsletter', ['email' => ' Reader@Example.com ', 'locale' => 'fr'])
            ->assertOk()->assertExactJson(['status' => 'pending']);

        $subscriber = Subscriber::sole();
        $this->assertSame('reader@example.com', $subscriber->email);
        $this->assertSame('fr', $subscriber->locale);
        $this->assertSame(Subscriber::PENDING, $subscriber->status);
        Mail::assertSent(ConfirmSubscription::class, fn ($mail) => $mail->hasTo('reader@example.com') && $mail->locale === 'fr');
    }

    public function test_invalid_emails_are_rejected(): void
    {
        $this->postJson('/api/newsletter', ['email' => 'not-an-email'])->assertStatus(422);
        $this->postJson('/api/newsletter', [])->assertStatus(422);
        $this->assertSame(0, Subscriber::count());
    }

    public function test_bots_filling_the_hidden_field_are_ignored(): void
    {
        Mail::fake();
        $this->postJson('/api/newsletter', ['email' => 'bot@example.com', 'website' => 'http://spam'])->assertOk();
        $this->assertSame(0, Subscriber::count());
        Mail::assertNothingSent();
    }

    public function test_signing_up_twice_does_not_reveal_or_duplicate_and_does_not_spam(): void
    {
        Mail::fake();
        $this->postJson('/api/newsletter', ['email' => 'a@example.com'])->assertExactJson(['status' => 'pending']);
        $this->postJson('/api/newsletter', ['email' => 'a@example.com'])->assertExactJson(['status' => 'pending']);

        $this->assertSame(1, Subscriber::count());
        Mail::assertSent(ConfirmSubscription::class, 1); // no second email within 10 minutes

        Subscriber::sole()->forceFill(['status' => Subscriber::CONFIRMED])->save();
        $this->postJson('/api/newsletter', ['email' => 'a@example.com'])->assertExactJson(['status' => 'pending']);
        $this->assertSame(Subscriber::CONFIRMED, Subscriber::sole()->status);
    }

    public function test_browsing_the_site_does_not_use_up_the_sign_up_limit(): void
    {
        Mail::fake();
        for ($i = 0; $i < 8; $i++) {
            $this->getJson('/api/site')->assertOk();
        }

        $this->postJson('/api/newsletter', ['email' => 'browser@example.com'])->assertOk();

        for ($i = 0; $i < 4; $i++) {
            $this->postJson('/api/newsletter', ['email' => "x{$i}@example.com"]);
        }
        $this->postJson('/api/newsletter', ['email' => 'late@example.com'])->assertStatus(429);
    }

    public function test_unknown_locales_fall_back_to_english(): void
    {
        Mail::fake();
        $this->postJson('/api/newsletter', ['email' => 'b@example.com', 'locale' => 'xx'])->assertOk();
        $this->assertSame('en', Subscriber::sole()->locale);
    }

    public function test_confirm_link_confirms_and_redirects_to_the_subscribers_language(): void
    {
        $subscriber = $this->subscriber('c@example.com', Subscriber::PENDING, 'de');

        $this->get('/newsletter/confirm/'.$subscriber->token)->assertRedirect('/de?newsletter=confirmed');
        $this->assertSame(Subscriber::CONFIRMED, $subscriber->fresh()->status);

        $this->get('/newsletter/confirm/'.str_repeat('x', 48))->assertRedirect('/?newsletter=invalid');
    }

    public function test_unsubscribe_link_only_asks_and_the_button_unsubscribes(): void
    {
        $subscriber = $this->subscriber('d@example.com');

        // Opening the link (or a link scanner) must not unsubscribe.
        $this->get('/newsletter/unsubscribe/'.$subscriber->token)
            ->assertRedirect('/?newsletter=unsubscribe&token='.$subscriber->token);
        $this->assertSame(Subscriber::CONFIRMED, $subscriber->fresh()->status);

        $this->postJson('/api/newsletter/unsubscribe', ['token' => $subscriber->token])->assertOk()->assertJson(['status' => 'unsubscribed']);
        $this->assertSame(Subscriber::UNSUBSCRIBED, $subscriber->fresh()->status);

        $this->postJson('/api/newsletter/unsubscribe', ['token' => 'nope'])->assertNotFound();
    }

    public function test_one_click_unsubscribe_from_the_mail_app(): void
    {
        $subscriber = $this->subscriber('e@example.com');
        $this->post('/newsletter/unsubscribe/'.$subscriber->token, ['List-Unsubscribe' => 'One-Click'])->assertOk();
        $this->assertSame(Subscriber::UNSUBSCRIBED, $subscriber->fresh()->status);
    }

    public function test_existing_tools_are_not_announced(): void
    {
        $this->assertSame(count(config('tools')), DB::table('announced_tools')->count());
        $this->artisan('newsletter:announce', ['--force' => true])->expectsOutput('No new tools to announce.')->assertSuccessful();
    }

    public function test_new_tools_are_emailed_once_to_confirmed_subscribers_in_their_language(): void
    {
        Mail::fake();
        $this->addTool('brand-new-tool');
        $en = $this->subscriber('en@example.com');
        $es = $this->subscriber('es@example.com', Subscriber::CONFIRMED, 'es');
        $this->subscriber('pending@example.com', Subscriber::PENDING);
        $this->subscriber('gone@example.com', Subscriber::UNSUBSCRIBED);

        $this->artisan('newsletter:announce', ['--force' => true])->assertSuccessful();

        Mail::assertSent(NewToolsAnnouncement::class, 2);
        Mail::assertSent(NewToolsAnnouncement::class, fn ($m) => $m->hasTo('en@example.com') && $m->tools[0]['url'] === 'https://toolzy.test/brand-new-tool');
        Mail::assertSent(NewToolsAnnouncement::class, fn ($m) => $m->hasTo('es@example.com') && $m->locale === 'es' && $m->tools[0]['url'] === 'https://toolzy.test/es/brand-new-tool');
        Mail::assertNotSent(NewToolsAnnouncement::class, fn ($m) => $m->hasTo('pending@example.com') || $m->hasTo('gone@example.com'));
        $this->assertSame(2, DB::table('announced_tools')->where('slug', 'brand-new-tool')->value('recipients'));

        // Running again sends nothing.
        $this->artisan('newsletter:announce', ['--force' => true])->expectsOutput('No new tools to announce.');
        Mail::assertSent(NewToolsAnnouncement::class, 2);
        unset($en, $es);
    }

    public function test_nothing_is_sent_or_recorded_until_a_mail_server_is_configured(): void
    {
        Mail::fake();
        config(['mail.default' => 'log']);
        $this->addTool('waiting-tool');
        $this->subscriber('f@example.com');

        $this->artisan('newsletter:announce')->assertSuccessful();

        Mail::assertNothingSent();
        $this->assertFalse(DB::table('announced_tools')->where('slug', 'waiting-tool')->exists());
    }

    public function test_announcement_email_renders_with_an_unsubscribe_link(): void
    {
        $subscriber = $this->subscriber('g@example.com', Subscriber::CONFIRMED, 'it');
        $mail = new NewToolsAnnouncement($subscriber, [[
            'name' => 'Tip Calculator', 'tagline' => 'Split the bill', 'url' => 'https://toolzy.test/it/tip-calculator', 'icon' => 'calculator', 'accent' => '#d97706',
        ]]);

        $html = $mail->render();
        $this->assertStringContainsString('Tip Calculator', $html);
        $this->assertStringContainsString('/newsletter/unsubscribe/'.$subscriber->token, $html);
        $this->assertStringContainsString('lang="it"', $html);
    }

    private function subscriber(string $email, string $status = Subscriber::CONFIRMED, string $locale = 'en'): Subscriber
    {
        return Subscriber::create(['email' => $email, 'status' => $status, 'locale' => $locale, 'token' => Subscriber::newToken()]);
    }

    /** Pretend a tool was just added to the site. */
    private function addTool(string $slug): void
    {
        $tools = config('tools');
        $tools[$slug] = ['name' => 'Brand New Tool', 'category' => 'text-tools', 'icon' => 'text', 'title' => 'T', 'description' => 'D', 'h1' => 'H', 'tagline' => 'A brand new tool.', 'intro' => 'I'];
        config(['tools' => $tools]);
        $this->app->forgetInstance(ToolRegistry::class);
        $this->app->singleton(ToolRegistry::class, fn () => new ToolRegistry(config('tools'), config('categories')));
    }
}

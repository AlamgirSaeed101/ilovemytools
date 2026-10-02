<?php

namespace Tests\Feature;

use App\Support\OpenPageRank;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DomainAuthorityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        config(['site.openpagerank.key' => 'opr_test_key', 'site.openpagerank.daily_limit' => 900]);
    }

    private function fakeApi(): void
    {
        Http::fake(['openpagerank.keywordseverywhere.com/*' => Http::response([
            'as_of' => '2026-09-01',
            'count' => 2,
            'results' => [
                ['domain' => 'github.com', 'found' => true, 'open_page_rank' => 9.67, 'rank' => 30, 'referring_domains' => 282833],
                ['domain' => 'unknown-site.example', 'found' => false, 'open_page_rank' => null],
            ],
            'invalid' => [],
        ])]);
    }

    public function test_domains_are_normalised(): void
    {
        $this->assertSame('example.com', OpenPageRank::normalize(' https://www.Example.com/page?x=1 '));
        $this->assertSame('blog.example.co.uk', OpenPageRank::normalize('blog.example.co.uk'));
        $this->assertSame('example.com', OpenPageRank::normalize('example.com:8080'));
        $this->assertNull(OpenPageRank::normalize('not a domain'));
        $this->assertNull(OpenPageRank::normalize('localhost'));
    }

    public function test_scores_are_returned_in_order_with_invalid_input_listed(): void
    {
        $this->fakeApi();
        $this->postJson('/api/domain-authority', ['domains' => ['https://www.github.com/', 'unknown-site.example', 'not a domain', '']])
            ->assertOk()
            ->assertJson([
                'as_of' => '2026-09-01',
                'results' => [
                    ['domain' => 'github.com', 'found' => true, 'score' => 9.67, 'rank' => 30, 'referring_domains' => 282833],
                    ['domain' => 'unknown-site.example', 'found' => false, 'score' => null],
                ],
                'invalid' => ['not a domain'],
            ]);

        Http::assertSent(fn ($r) => $r->hasHeader('Authorization', 'Bearer opr_test_key')
            && $r['domains'] === ['github.com', 'unknown-site.example'] && $r['include_history'] === false);
    }

    public function test_results_are_cached_so_repeat_lookups_use_no_quota(): void
    {
        $this->fakeApi();
        $this->postJson('/api/domain-authority', ['domains' => ['github.com']])->assertOk();
        $this->postJson('/api/domain-authority', ['domains' => ['github.com']])->assertOk()->assertJsonPath('results.0.score', 9.67);
        Http::assertSentCount(1);
    }

    public function test_daily_cap_and_limits(): void
    {
        $this->fakeApi();
        config(['site.openpagerank.daily_limit' => 1]);
        $this->postJson('/api/domain-authority', ['domains' => ['a-site.com', 'b-site.com']])->assertOk()->assertJson(['error' => 'daily-limit']);

        $many = array_map(fn ($i) => "site$i.com", range(1, 101));
        $this->postJson('/api/domain-authority', ['domains' => $many])->assertStatus(422)->assertJson(['error' => 'too-many']);
    }

    public function test_tool_is_off_until_a_key_is_configured(): void
    {
        config(['site.openpagerank.key' => null]);
        Http::fake();
        $this->postJson('/api/domain-authority', ['domains' => ['github.com']])->assertOk()->assertJson(['error' => 'not-configured']);
        Http::assertNothingSent();
    }
}

<?php

namespace Tests\Feature;

use App\Support\Rdap;
use App\Support\SafeUrl;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DomainAgeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    /** Pretend DNS: every host resolves to the given IP. */
    private function rdap(string $ip = '93.184.216.34'): Rdap
    {
        return new Rdap(new SafeUrl(fn (string $host) => [$ip]));
    }

    private function record(): array
    {
        return [
            'objectClassName' => 'domain',
            'ldhName' => 'EXAMPLE.COM',
            'events' => [
                ['eventAction' => 'registration', 'eventDate' => '1995-08-14T04:00:00Z'],
                ['eventAction' => 'expiration', 'eventDate' => '2026-08-13T04:00:00Z'],
                ['eventAction' => 'last changed', 'eventDate' => '2024-08-14T07:01:31Z'],
            ],
            'status' => ['client delete prohibited', 'client transfer prohibited'],
            'nameservers' => [
                ['ldhName' => 'A.IANA-SERVERS.NET'],
                ['ldhName' => 'B.IANA-SERVERS.NET'],
            ],
            'entities' => [
                [
                    'roles' => ['registrar'],
                    'vcardArray' => ['vcard', [
                        ['version', (object) [], 'text', '4.0'],
                        ['fn', (object) [], 'text', 'RESERVED-Internet Assigned Numbers Authority'],
                    ]],
                ],
            ],
        ];
    }

    public function test_domains_are_normalised(): void
    {
        $this->assertSame('example.com', Rdap::normalize(' https://www.Example.com/page?x=1 '));
        $this->assertNull(Rdap::normalize('not a domain'));
    }

    public function test_a_record_is_parsed_from_rdap_json(): void
    {
        Http::fake([
            'rdap.org/domain/example.com' => Http::response('', 302, ['Location' => 'https://rdap.verisign.com/com/v1/domain/example.com']),
            'rdap.verisign.com/*' => Http::response($this->record(), 200),
        ]);

        $result = $this->rdap()->lookup('example.com');

        $this->assertSame('1995-08-14T04:00:00Z', $result['created']);
        $this->assertSame('2026-08-13T04:00:00Z', $result['expires']);
        $this->assertSame('2024-08-14T07:01:31Z', $result['updated']);
        $this->assertSame('RESERVED-Internet Assigned Numbers Authority', $result['registrar']);
        $this->assertSame(['client delete prohibited', 'client transfer prohibited'], $result['status']);
        $this->assertSame(['a.iana-servers.net', 'b.iana-servers.net'], $result['nameservers']);
    }

    public function test_a_404_straight_from_rdap_org_means_the_tld_is_not_supported(): void
    {
        Http::fake(['rdap.org/*' => Http::response(['errorCode' => 404], 404)]);
        $this->assertSame(['error' => 'tld-not-supported'], $this->rdap()->lookup('example.nosuchtld'));
    }

    public function test_a_404_after_a_redirect_means_the_domain_has_no_record(): void
    {
        Http::fake([
            'rdap.org/domain/never-registered.com' => Http::response('', 302, ['Location' => 'https://rdap.verisign.com/com/v1/domain/never-registered.com']),
            'rdap.verisign.com/*' => Http::response(['errorCode' => 404], 404),
        ]);
        $this->assertSame(['error' => 'not-found'], $this->rdap()->lookup('never-registered.com'));
    }

    public function test_results_are_cached_so_repeat_lookups_make_no_request(): void
    {
        Http::fake([
            'rdap.org/domain/example.com' => Http::response('', 302, ['Location' => 'https://rdap.verisign.com/com/v1/domain/example.com']),
            'rdap.verisign.com/*' => Http::response($this->record(), 200),
        ]);
        $rdap = $this->rdap();
        $rdap->lookup('example.com');
        $rdap->lookup('example.com');
        Http::assertSentCount(2); // one redirect + one fetch, only on the first call
    }

    public function test_a_redirect_to_a_private_address_is_refused(): void
    {
        Http::fake(['rdap.org/*' => Http::response('', 302, ['Location' => 'http://169.254.169.254/latest/meta-data/'])]);
        $this->assertSame(['error' => 'unavailable'], $this->rdap()->lookup('example.com'));
        Http::assertNotSent(fn ($request) => str_contains($request->url(), '169.254.169.254'));
    }

    public function test_api_validates_input_and_returns_results_in_order(): void
    {
        Http::fake([
            'rdap.org/domain/example.com' => Http::response('', 302, ['Location' => 'https://rdap.verisign.com/com/v1/domain/example.com']),
            'rdap.verisign.com/*' => Http::response($this->record(), 200),
        ]);

        $this->postJson('/api/domain-age', ['domains' => ['https://www.example.com/', 'not a domain', '']])
            ->assertOk()
            ->assertJsonPath('results.0.domain', 'example.com')
            ->assertJsonPath('results.0.registrar', 'RESERVED-Internet Assigned Numbers Authority')
            ->assertJsonPath('invalid', ['not a domain']);

        $this->postJson('/api/domain-age', ['domains' => []])->assertStatus(422);
        $many = array_map(fn ($i) => "site$i.com", range(1, 21));
        $this->postJson('/api/domain-age', ['domains' => $many])->assertStatus(422)->assertJson(['error' => 'too-many']);
    }

    public function test_api_never_reaches_a_private_address_even_if_given_one_directly(): void
    {
        Http::fake();
        // Not a valid domain shape, so it is skipped before any RDAP request is made.
        $this->postJson('/api/domain-age', ['domains' => ['127.0.0.1', 'localhost']])
            ->assertOk()
            ->assertJsonCount(2, 'invalid');
        Http::assertNothingSent();
    }
}

<?php

namespace Tests\Feature;

use App\Support\DomainInfo;
use App\Support\OpenPageRank;
use App\Support\Rdap;
use App\Support\SafeUrl;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DomainDetailsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        config(['site.openpagerank.key' => null]);
    }

    /** DomainInfo with pretend DNS records and HTTPS answer; RDAP goes through Http::fake. */
    private function info(array $dns, ?array $tls = ['valid' => true, 'issuer' => "Let's Encrypt", 'expires' => '2027-01-01T00:00:00Z']): DomainInfo
    {
        return new DomainInfo(
            new Rdap(new SafeUrl(fn (string $host) => ['93.184.216.34'])),
            new OpenPageRank,
            fn (string $host, int $type) => $dns[$host][$type] ?? [],
            fn (string $domain, string $ip) => $tls,
        );
    }

    private function rdapDomain(): array
    {
        return [
            'events' => [['eventAction' => 'registration', 'eventDate' => '1995-08-14T04:00:00Z']],
            'entities' => [['roles' => ['registrar'], 'vcardArray' => ['vcard', [['fn', (object) [], 'text', 'Example Registrar']]]]],
        ];
    }

    public function test_full_report_with_hosting_from_team_cymru(): void
    {
        Http::fake(['rdap.org/domain/*' => Http::response($this->rdapDomain(), 200)]);
        $info = $this->info([
            'example.com' => [
                DNS_A => [['ip' => '104.16.1.1']],
                DNS_NS => [['target' => 'ADA.NS.CLOUDFLARE.COM'], ['target' => 'bob.ns.cloudflare.com']],
                DNS_MX => [['pri' => 20, 'target' => 'alt1.aspmx.l.google.com'], ['pri' => 10, 'target' => 'aspmx.l.google.com']],
            ],
            '1.1.16.104.origin.asn.cymru.com' => [DNS_TXT => [['txt' => '13335 | 104.16.0.0/13 | US | arin | 2014-03-28']]],
            'AS13335.asn.cymru.com' => [DNS_TXT => [['txt' => '13335 | US | arin | 2010-07-14 | CLOUDFLARENET, US']]],
        ]);

        $r = $info->lookup('example.com');

        $this->assertTrue($r['resolves']);
        $this->assertSame('Example Registrar', $r['registration']['registrar']);
        $this->assertSame('Cloudflare', $r['dns']['dns_provider']);
        $this->assertSame(['aspmx.l.google.com', 'alt1.aspmx.l.google.com'], $r['dns']['mx']);
        $this->assertSame('Google Workspace', $r['dns']['mail_provider']);
        $this->assertSame(['ip' => '104.16.1.1', 'asn' => 13335, 'network' => 'CLOUDFLARENET', 'prefix' => '104.16.0.0/13', 'country' => 'US'], $r['hosting']);
        $this->assertTrue($r['https']['valid']);
        $this->assertNull($r['score']);
    }

    public function test_hosting_falls_back_to_the_ip_owner_from_rdap(): void
    {
        Http::fake([
            'rdap.org/domain/*' => Http::response($this->rdapDomain(), 200),
            'rdap.org/ip/*' => Http::response([
                'name' => 'SUCURI-ARIN-002',
                'entities' => [['roles' => ['registrant'], 'vcardArray' => ['vcard', [['fn', (object) [], 'text', 'Sucuri']]]]],
            ], 200),
        ]);

        $r = $this->info(['example.com' => [DNS_A => [['ip' => '192.124.249.6']]]])->lookup('example.com');

        $this->assertSame('Sucuri', $r['hosting']['network']);
        $this->assertNull($r['hosting']['asn']);
    }

    public function test_private_ips_are_never_looked_up_or_connected_to(): void
    {
        Http::fake(['rdap.org/domain/*' => Http::response($this->rdapDomain(), 200)]);
        $connected = false;
        $info = new DomainInfo(
            new Rdap(new SafeUrl(fn () => ['93.184.216.34'])),
            new OpenPageRank,
            fn (string $host, int $type) => $type === DNS_A ? [['ip' => '10.0.0.5']] : [],
            function () use (&$connected) {
                $connected = true;

                return null;
            },
        );

        $r = $info->lookup('example.com');

        $this->assertNull($r['hosting']);
        $this->assertNull($r['https']);
        $this->assertFalse($connected);
    }

    public function test_endpoint_validates_and_normalises_the_domain(): void
    {
        Http::fake(['rdap.org/*' => Http::response($this->rdapDomain(), 200)]);
        $this->app->instance(DomainInfo::class, $this->info([]));

        $this->postJson('/api/domain-details', ['domain' => 'not a domain'])->assertStatus(422);
        $this->postJson('/api/domain-details', ['domain' => 'https://www.Example.com/page'])
            ->assertOk()
            ->assertJsonPath('domain', 'example.com')
            ->assertJsonPath('resolves', false)
            ->assertJsonPath('registration.registrar', 'Example Registrar');
    }
}

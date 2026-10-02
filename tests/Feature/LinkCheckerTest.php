<?php

namespace Tests\Feature;

use App\Support\LinkChecker;
use App\Support\SafeUrl;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LinkCheckerTest extends TestCase
{
    /** Pretend DNS: every host resolves to the given IPs. */
    private function guard(array $ips = ['93.184.216.34']): SafeUrl
    {
        return new SafeUrl(fn (string $host) => $ips);
    }

    private function checker(array $ips = ['93.184.216.34']): LinkChecker
    {
        return new LinkChecker($this->guard($ips));
    }

    public function test_only_public_http_urls_on_standard_ports_are_allowed(): void
    {
        $g = $this->guard();
        $this->assertSame('93.184.216.34', $g->check('https://example.com/page')['ip']);
        foreach ([
            'ftp://example.com/', 'file:///etc/passwd', 'https://example.com:8080/', 'https://user:pass@example.com/',
            'http://localhost/', 'http://printer.local/', 'http://127.0.0.1/', 'http://10.1.2.3/', 'http://192.168.0.1/',
            'http://172.16.5.5/', 'http://169.254.169.254/latest/meta-data/', 'http://100.64.1.1/', 'http://[::1]/', 'http://[fd00::1]/',
        ] as $url) {
            $this->assertSame('not-allowed', $g->check($url), $url);
        }
    }

    public function test_a_host_with_any_private_record_is_refused_and_unknown_hosts_report_dns(): void
    {
        $this->assertSame('not-allowed', $this->guard(['93.184.216.34', '10.0.0.5'])->check('https://rebind.example/'));
        $this->assertSame('dns', $this->guard([])->check('https://no-such-host.example/'));
    }

    public function test_user_input_is_normalised(): void
    {
        $this->assertSame('https://example.com/a', SafeUrl::normalize(' example.com/a '));
        $this->assertSame('http://example.com', SafeUrl::normalize('http://example.com'));
        $this->assertNull(SafeUrl::normalize(''));
        $this->assertNull(SafeUrl::normalize('javascript:alert(1)'));
    }

    public function test_relative_links_are_resolved(): void
    {
        $base = 'https://example.com/blog/post.html';
        $this->assertSame('https://example.com/blog/other', LinkChecker::resolve('other', $base));
        $this->assertSame('https://example.com/about', LinkChecker::resolve('/about#team', $base));
        $this->assertSame('https://example.com/img/a.png', LinkChecker::resolve('../img/a.png', $base));
        $this->assertSame('https://cdn.example.net/x.js', LinkChecker::resolve('//cdn.example.net/x.js', $base));
        $this->assertSame('https://example.com/blog/post.html?page=2', LinkChecker::resolve('?page=2', $base));
        $this->assertNull(LinkChecker::resolve('mailto:hi@example.com', $base));
    }

    public function test_links_and_images_are_listed_once_with_their_text(): void
    {
        $html = '<base href="https://example.com/docs/"><a href="a">First</a><a href="a#x">Dup</a><a href="mailto:x@y.z">Mail</a>'
            .'<a href="https://other.org/">  Other   site </a><a href="#top">Top</a><img src="/logo.png" alt="Logo">';
        $r = $this->checker()->linksIn($html, 'https://example.com/docs/index.html');
        $this->assertSame([
            ['url' => 'https://example.com/docs/a', 'text' => 'First', 'type' => 'link', 'internal' => true],
            ['url' => 'https://other.org/', 'text' => 'Other site', 'type' => 'link', 'internal' => false],
            ['url' => 'https://example.com/logo.png', 'text' => 'Logo', 'type' => 'image', 'internal' => true],
        ], $r['links']);
        $this->assertFalse($r['truncated']);
    }

    public function test_statuses_redirects_and_head_fallback(): void
    {
        Http::fake([
            'example.com/ok' => Http::response('', 200),
            'example.com/gone' => Http::response('', 404),
            'example.com/old' => Http::response('', 301, ['Location' => '/new']),
            'example.com/new' => Http::response('', 200),
            // Answers 405 to HEAD but 200 to GET.
            'example.com/no-head' => fn ($request) => Http::response('', $request->method() === 'HEAD' ? 405 : 200),
        ]);

        $results = collect($this->checker()->check([
            'https://example.com/ok', 'https://example.com/gone', 'https://example.com/old', 'https://example.com/no-head', 'http://127.0.0.1/admin',
        ]))->keyBy('url');

        $this->assertSame(200, $results['https://example.com/ok']['status']);
        $this->assertSame(404, $results['https://example.com/gone']['status']);
        $this->assertSame(200, $results['https://example.com/old']['status']);
        $this->assertSame(1, $results['https://example.com/old']['redirects']);
        $this->assertSame('https://example.com/new', $results['https://example.com/old']['final']);
        $this->assertSame(200, $results['https://example.com/no-head']['status']);
        $this->assertSame('not-allowed', $results['http://127.0.0.1/admin']['error']);
        Http::assertNotSent(fn ($request) => str_contains($request->url(), '127.0.0.1'));
    }

    public function test_redirects_to_private_addresses_are_not_followed(): void
    {
        Http::fake(['example.com/*' => Http::response('', 302, ['Location' => 'http://169.254.169.254/latest/meta-data/'])]);
        $r = $this->checker()->check(['https://example.com/trap'])[0];
        $this->assertSame('not-allowed', $r['error']);
        Http::assertSentCount(1);
    }

    public function test_api_validates_input_and_refuses_private_urls(): void
    {
        $this->postJson('/api/links/extract', ['url' => ''])->assertOk()->assertJson(['error' => 'invalid-url']);
        $this->postJson('/api/links/check', ['urls' => []])->assertStatus(422);
        $this->postJson('/api/links/check', ['urls' => array_fill(0, 21, 'https://example.com/')])->assertStatus(422);
        $this->postJson('/api/links/check', ['urls' => ['javascript:alert(1)']])->assertStatus(422);
        $this->postJson('/api/links/extract', ['url' => 'http://127.0.0.1/'])->assertOk()->assertJson(['error' => 'not-allowed']);
    }
}

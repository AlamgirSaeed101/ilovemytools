<?php

namespace App\Providers;

use App\Support\SiteData;
use App\Support\ToolRegistry;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ToolRegistry::class, fn () => new ToolRegistry(
            config('tools', []),
            config('categories', []),
        ));

        $this->app->singleton(SiteData::class);
    }

    public function boot(): void
    {
        // Real visitor IP behind Cloudflare / a load balancer (used by "What Is My IP"
        // and rate limiting). Only listed proxies may set X-Forwarded-For; with none
        // listed the header is ignored, so visitors cannot fake their IP.
        $proxies = array_values(array_filter(array_map('trim', explode(',', (string) config('site.trusted_proxies', '')))));
        if ($proxies !== []) {
            TrustProxies::at($proxies === ['*'] ? '*' : $proxies);
        }

        // SEO: always generate https:// URLs in production so canonical tags match.
        if ($this->app->environment('production') && config('site.force_https')) {
            URL::forceScheme('https');
        }

        // The tool registry (navigation, footer, related tools) is available in every view.
        View::share('registry', $this->app->make(ToolRegistry::class));
    }
}

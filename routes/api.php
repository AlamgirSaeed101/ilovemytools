<?php

use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\DomainAgeController;
use App\Http\Controllers\DomainAuthorityController;
use App\Http\Controllers\IpController;
use App\Http\Controllers\LinkCheckerController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| JSON API used by the React front end (all URLs are prefixed with /api)
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:120,1,api')->group(function () {
    Route::get('/site', [SiteController::class, 'site'])->name('api.site');
    Route::get('/tools/{slug}', [SiteController::class, 'tool'])->name('api.tool');
    Route::get('/categories/{slug}', [SiteController::class, 'category'])->name('api.category');
    Route::get('/guides/{guide}', [\App\Http\Controllers\GuideController::class, 'api'])->name('api.guide');
});

Route::get('/ip', [IpController::class, 'show'])
    ->middleware('throttle:60,1,ip')
    ->name('api.ip');

// Newsletter sign-up and the unsubscribe button (strictly rate limited).
Route::middleware('throttle:5,1,newsletter')->group(function () {
    Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('api.newsletter.subscribe');
    Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('api.newsletter.unsubscribe');
});

// Broken Link Checker: the server fetches other sites, so both endpoints are strictly limited.
Route::post('/links/extract', [LinkCheckerController::class, 'extract'])->middleware('throttle:10,1,links-extract')->name('api.links.extract');
Route::post('/links/check', [LinkCheckerController::class, 'check'])->middleware('throttle:40,1,links-check')->name('api.links.check');

// Domain Authority Checker (OpenPageRank API, cached; the daily cap is in config/site.php).
Route::post('/domain-authority', [DomainAuthorityController::class, 'check'])->middleware('throttle:10,1,domain-authority')->name('api.domain-authority');
// Its per-domain "Details" panel: RDAP, DNS, hosting network (Team Cymru), HTTPS; cached 6 hours.
Route::post('/domain-details', [DomainAuthorityController::class, 'details'])->middleware('throttle:20,1,domain-details')->name('api.domain-details');

// Domain Age Checker: the server fetches RDAP (rdap.org and the registry it redirects to), cached for a day.
Route::post('/domain-age', [DomainAgeController::class, 'check'])->middleware('throttle:20,1,domain-age')->name('api.domain-age');

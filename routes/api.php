<?php

use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\IpController;
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
});

Route::get('/ip', [IpController::class, 'show'])
    ->middleware('throttle:60,1,ip')
    ->name('api.ip');

// Newsletter sign-up and the unsubscribe button (strictly rate limited).
Route::middleware('throttle:5,1,newsletter')->group(function () {
    Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('api.newsletter.subscribe');
    Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('api.newsletter.unsubscribe');
});

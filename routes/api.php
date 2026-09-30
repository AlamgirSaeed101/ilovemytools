<?php

use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\IpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| JSON API used by the React front end (all URLs are prefixed with /api)
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:120,1')->group(function () {
    Route::get('/site', [SiteController::class, 'site'])->name('api.site');
    Route::get('/tools/{slug}', [SiteController::class, 'tool'])->name('api.tool');
    Route::get('/categories/{slug}', [SiteController::class, 'category'])->name('api.category');
});

Route::get('/ip', [IpController::class, 'show'])
    ->middleware('throttle:60,1')
    ->name('api.ip');

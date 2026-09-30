<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoFilesController;
use App\Support\Locale;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SEO files
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SeoFilesController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoFilesController::class, 'robots'])->name('robots');
Route::get('/ads.txt', [SeoFilesController::class, 'ads'])->name('ads');

/*
|--------------------------------------------------------------------------
| Pages (the React app, with a server-rendered SEO shell)
|--------------------------------------------------------------------------
| Registered once for English at the root (/merge-pdf) and once per language
| under its prefix (/es/merge-pdf). Keep in sync with resources/js/app.jsx.
*/
$toolSlugs = array_keys(config('tools', []));

$pages = function () use ($toolSlugs) {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/category/{category}', [PageController::class, 'category'])->name('category');

    // Tools: short keyword URLs. Only slugs in config/tools.php match.
    if ($toolSlugs !== []) {
        Route::get('/{tool}', [PageController::class, 'tool'])
            ->where('tool', implode('|', array_map(fn ($slug) => preg_quote($slug, '/'), $toolSlugs)))
            ->name('tool');
    }
};

Route::middleware('locale:'.Locale::default())->group($pages);

foreach (Locale::codes() as $code) {
    if ($code !== Locale::default()) {
        Route::prefix($code)->middleware('locale:'.$code)->name($code.'.')->group($pages);
    }
}

Route::fallback([PageController::class, 'notFound']);

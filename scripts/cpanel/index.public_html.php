<?php

use Illuminate\Http\Request;

/*
| cPanel entry point. The Laravel app lives outside the web root in ~/toolzy;
| this folder (public_html) holds only the public files (build assets, icons).
| Redeploying copies ~/toolzy/public here again, except this index.php.
*/

define('LARAVEL_START', microtime(true));

$app = __DIR__.'/../toolzy';

if (file_exists($maintenance = $app.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $app.'/vendor/autoload.php';

(require_once $app.'/bootstrap/app.php')
    ->usePublicPath(__DIR__)
    ->handleRequest(Request::capture());

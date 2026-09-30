<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Scheduled tasks
|--------------------------------------------------------------------------
| The server's cron runs `php artisan schedule:run` every minute.
*/

// Email newsletter subscribers when a new tool goes live.
Schedule::command('newsletter:announce')->hourly()->withoutOverlapping();

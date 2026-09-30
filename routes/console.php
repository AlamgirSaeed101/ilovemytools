<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Scheduled tasks
|--------------------------------------------------------------------------
| The server's cron runs `php artisan schedule:run` every minute.
*/

// Email newsletter subscribers when a new tool goes live.
Schedule::command('newsletter:announce')->hourly()->withoutOverlapping();

// Check the SMTP settings: php artisan newsletter:test-mail you@example.com
Artisan::command('newsletter:test-mail {to}', function (string $to) {
    Mail::raw('This is a test email from '.config('app.name').'. The newsletter email settings work.', function ($message) use ($to) {
        $message->to($to)->subject(config('app.name').' newsletter: test email');
    });
    $this->info('Test email sent to '.$to.' via '.config('mail.default').'.');
})->purpose('Send a test email to check the mail settings');

<?php

namespace App\Console\Commands;

use App\Mail\NewToolsAnnouncement;
use App\Models\Subscriber;
use App\Support\Locale;
use App\Support\ToolRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Email confirmed subscribers about tools added since the last announcement.
 *
 * Runs hourly from the scheduler. Each tool is announced once: it is recorded in
 * `announced_tools` after sending. While no real mailer is configured (MAIL_MAILER
 * is "log" or "array") nothing is sent or recorded, so no announcement is lost.
 */
class AnnounceNewTools extends Command
{
    protected $signature = 'newsletter:announce {--force : Send even if the mailer is "log" or "array"} {--dry-run : Only list the tools that would be announced}';

    protected $description = 'Email newsletter subscribers about newly added tools';

    public function handle(ToolRegistry $registry): int
    {
        $announced = DB::table('announced_tools')->pluck('slug')->all();
        $new = array_values(array_diff($registry->slugs(), $announced));

        if ($new === []) {
            $this->info('No new tools to announce.');

            return self::SUCCESS;
        }

        $this->info('New tools: '.implode(', ', $new));
        if ($this->option('dry-run')) {
            return self::SUCCESS;
        }

        if (in_array(config('mail.default'), ['log', 'array'], true) && ! $this->option('force')) {
            $this->warn('No mail server configured (MAIL_MAILER='.config('mail.default').'). Nothing sent; the tools will be announced once email is set up.');

            return self::SUCCESS;
        }

        $sent = 0;
        $failed = 0;
        $previousLocale = app()->getLocale();

        Subscriber::confirmed()->orderBy('id')->chunkById(200, function ($subscribers) use ($registry, $new, &$sent, &$failed) {
            foreach ($subscribers as $subscriber) {
                app()->setLocale(Locale::isSupported($subscriber->locale) ? $subscriber->locale : Locale::default());
                $tools = array_values(array_filter(array_map(fn ($slug) => $this->toolForEmail($registry, $slug, $subscriber->locale), $new)));
                try {
                    Mail::to($subscriber->email)->send(new NewToolsAnnouncement($subscriber, $tools));
                    $sent++;
                } catch (Throwable $e) {
                    $failed++;
                    Log::warning('Newsletter announcement failed', ['subscriber' => $subscriber->id, 'error' => $e->getMessage()]);
                }
            }
        });

        app()->setLocale($previousLocale);

        $now = now();
        foreach ($new as $slug) {
            DB::table('announced_tools')->updateOrInsert(['slug' => $slug], ['recipients' => $sent, 'announced_at' => $now]);
        }

        $this->info("Sent to {$sent} subscriber(s)".($failed ? ", {$failed} failed" : '').'.');

        return self::SUCCESS;
    }

    /** @return array{name: string, tagline: string, url: string, icon: string, accent: string}|null */
    private function toolForEmail(ToolRegistry $registry, string $slug, string $locale): ?array
    {
        $tool = $registry->find($slug);
        if ($tool === null) {
            return null;
        }

        return [
            'name' => $tool['name'],
            'tagline' => $tool['tagline'] ?? '',
            'url' => Locale::url($slug, $locale),
            'icon' => $tool['icon'] ?? 'sparkles',
            'accent' => $registry->category($tool['category'])['accent'] ?? '#2563eb',
        ];
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Newsletter subscribers (double opt-in: pending -> confirmed -> unsubscribed).
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 254)->unique();
            $table->string('locale', 8)->default('en');
            $table->string('status', 16)->default('pending')->index();
            $table->string('token', 64)->unique();
            $table->timestamp('confirmation_sent_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamps();
        });

        // Tools that have already been announced, so each tool is emailed exactly once.
        Schema::create('announced_tools', function (Blueprint $table) {
            $table->string('slug', 100)->primary();
            $table->unsignedInteger('recipients')->default(0);
            $table->timestamp('announced_at')->nullable();
        });

        // Every tool that exists when the newsletter launches counts as already announced:
        // only tools added after this point are emailed to subscribers.
        $now = now();
        $rows = array_map(fn ($slug) => ['slug' => $slug, 'recipients' => 0, 'announced_at' => $now], array_keys(config('tools', [])));
        if ($rows !== []) {
            DB::table('announced_tools')->insert($rows);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('announced_tools');
        Schema::dropIfExists('subscribers');
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * A newsletter subscriber.
 *
 * @property int $id
 * @property string $email
 * @property string $locale
 * @property string $status pending | confirmed | unsubscribed
 * @property string $token secret used in confirm and unsubscribe links
 */
class Subscriber extends Model
{
    public const PENDING = 'pending';

    public const CONFIRMED = 'confirmed';

    public const UNSUBSCRIBED = 'unsubscribed';

    protected $fillable = ['email', 'locale', 'status', 'token', 'confirmation_sent_at', 'confirmed_at', 'unsubscribed_at'];

    protected $hidden = ['token'];

    protected function casts(): array
    {
        return [
            'confirmation_sent_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    public static function newToken(): string
    {
        return Str::random(48);
    }

    /** @param Builder<Subscriber> $query */
    public function scopeConfirmed(Builder $query): void
    {
        $query->where('status', self::CONFIRMED);
    }
}

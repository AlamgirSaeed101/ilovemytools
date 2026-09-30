<?php

namespace App\Mail;

use App\Models\Subscriber;
use App\Support\Locale;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** "Please confirm your subscription" (double opt-in). */
class ConfirmSubscription extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Subscriber $subscriber)
    {
        $this->locale($subscriber->locale);
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: Locale::t('Confirm your subscription to {name}', ['name' => config('site.name')]));
    }

    public function content(): Content
    {
        return new Content(view: 'emails.confirm', with: [
            'confirmUrl' => url('/newsletter/confirm/'.$this->subscriber->token),
        ]);
    }
}

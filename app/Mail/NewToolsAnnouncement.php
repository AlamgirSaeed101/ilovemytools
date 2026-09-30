<?php

namespace App\Mail;

use App\Models\Subscriber;
use App\Support\Locale;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

/** "New on the site: ..." - one email listing every tool added since the last announcement. */
class NewToolsAnnouncement extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, array{name: string, tagline: string, url: string, icon: string, accent: string}>  $tools  already in the subscriber's language
     */
    public function __construct(public Subscriber $subscriber, public array $tools)
    {
        $this->locale($subscriber->locale);
    }

    public function envelope(): Envelope
    {
        $name = (string) config('site.name');
        $subject = count($this->tools) === 1
            ? Locale::t('New on {name}: {tool}', ['name' => $name, 'tool' => $this->tools[0]['name']])
            : Locale::t('{count} new free tools on {name}', ['name' => $name, 'count' => count($this->tools)]);

        return new Envelope(subject: $subject);
    }

    /** One-click unsubscribe in Gmail, Outlook and Apple Mail (RFC 8058). */
    public function headers(): Headers
    {
        $url = $this->unsubscribeUrl();

        return new Headers(text: [
            'List-Unsubscribe' => '<'.$url.'>',
            'List-Unsubscribe-Post' => 'List-Unsubscribe=One-Click',
        ]);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-tools', with: [
            'unsubscribeUrl' => $this->unsubscribeUrl(),
            'homeUrl' => Locale::url('/', $this->subscriber->locale),
        ]);
    }

    private function unsubscribeUrl(): string
    {
        return url('/newsletter/unsubscribe/'.$this->subscriber->token);
    }
}

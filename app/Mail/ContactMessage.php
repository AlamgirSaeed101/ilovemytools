<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** A message from the contact form. Replying goes straight to the visitor. */
class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $senderName, public string $senderEmail, public string $body) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact form: '.$this->senderName,
            replyTo: [new Address($this->senderEmail, $this->senderName)],
        );
    }

    public function content(): Content
    {
        return new Content(text: 'emails.contact-message');
    }
}

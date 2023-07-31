<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $appName;
    public $subscriberEmail;
    /**
     * Create a new message instance.
     */
    public function __construct($appName, $subscriberEmail)
    {
        $this->appName = $appName;
        $this->subscriberEmail = $subscriberEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Status Changed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription_status_changed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

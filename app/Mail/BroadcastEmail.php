<?php

namespace App\Mail;

use App\Domain\ReactEmail\ReactMailable;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BroadcastEmail extends ReactMailable
{
    use Queueable, SerializesModels;

    private TenantEmailConfiguration $configuration;

    public function __construct(
        private string $broadcast_subject,
        private string $broadcast_message,
        private Contact $contact
    ) {
        $this->configuration = TenantEmailConfiguration::for($this->contact->business);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->configuration->from(),
            subject: $this->broadcast_subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'marketing-email',
            with: [
                'companyName' => $this->contact->business->name,
                'message' => $this->broadcast_message,
                'unsubscribeUrl' => $this->configuration->unsubscribeUrl($this->contact->value),
            ]
        );
    }
}

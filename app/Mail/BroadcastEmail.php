<?php

namespace App\Mail;

use App\Domain\ReactEmail\ReactMailable;
use App\Models\Broadcast;
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
        private Broadcast $broadcast,
        private Contact $contact
    ) {
        $this->configuration = TenantEmailConfiguration::for($this->contact->business);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->configuration->from(),
            subject: $this->broadcast->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'broadcast',
            with: [
                'companyName' => $this->contact->business->name,
                'message' => $this->broadcast->message,
                'unsubscribeUrl' => $this->configuration->unsubscribeUrl($this->contact->value),
            ]
        );
    }
}

<?php

namespace App\Mail;

use App\Domain\ReactEmail\ReactMailable;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewRequest extends ReactMailable
{
    use Queueable, SerializesModels;

    private TenantEmailConfiguration $configuration;

    public function __construct(
        private Contact $contact
    ) {
        $this->configuration = TenantEmailConfiguration::for($this->contact->business);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->configuration->from(),
            subject: "Thanks for visiting {$this->contact->business->name}!"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'review-request',
            with: [
                'companyName' => $this->contact->business->name,
                'reviewUrl' => "https://{$this->contact->business->slug}.onrecallcx.com/review",
                'unsubscribeUrl' => $this->configuration->unsubscribeUrl($this->contact->value),
            ]
        );
    }
}

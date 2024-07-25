<?php

namespace App\Mail;

use App\Domain\ReactEmail\ReactMailable;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailConfirmation extends ReactMailable
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
            subject: "Here's {$this->contact->business->business_incentive->formatted()} your {$this->contact->business->name} purchase!"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email-confirmation',
            with: [
                'companyName' => $this->contact->business->name,
                'companyAddress' => $this->contact->business->address,
                'discount' => $this->contact->business->business_incentive->formatted(),
                'unsubscribeUrl' => $this->configuration->unsubscribeUrl($this->contact->value),
            ]
        );
    }
}

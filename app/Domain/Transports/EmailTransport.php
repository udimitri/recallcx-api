<?php

namespace App\Domain\Transports;

use App\Exceptions\ContactMustBeEmail;
use App\Mail\EmailConfirmation;
use App\Mail\ReviewRequest;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use Illuminate\Support\Facades\Mail;

class EmailTransport implements Transport
{
    public function __construct(private Contact $contact)
    {
        if ($this->contact->channel !== ContactType::Email) {
            throw new ContactMustBeEmail();
        }
    }

    public function sendReviewRequest(): void
    {
        Mail::to($this->contact->value)
            ->send(new ReviewRequest($this->contact));
    }

    public function sendConfirmation(): void
    {
        Mail::to($this->contact->value)
            ->send(new EmailConfirmation($this->contact));
    }
}

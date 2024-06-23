<?php

namespace App\Domain\Transports;

use App\Exceptions\ContactMustBeEmail;
use App\Mail\BroadcastEmail;
use App\Mail\EmailConfirmation;
use App\Mail\ReviewRequest;
use App\Models\Broadcast;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use Illuminate\Contracts\Mail\Mailable;
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
        $this->send(new ReviewRequest($this->contact));
    }

    public function sendConfirmation(): void
    {
        $this->send(new EmailConfirmation($this->contact));
    }

    public function sendBroadcast(Broadcast $broadcast): void
    {
        $this->send(new BroadcastEmail($broadcast, $this->contact));
    }

    private function send(Mailable $mailable): void
    {
        Mail::to($this->contact->value)
            ->send($mailable);
    }
}

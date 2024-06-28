<?php

namespace App\Domain\Messenger\Messages;

use App\Domain\Messenger\Message;
use App\Mail;
use App\Models\Contact;
use App\Models\Enums\MessageType;
use Illuminate\Mail\Mailable;

class SignupConfirmationMessage implements Message
{

    public function email(Contact $contact): Mailable
    {
        return new Mail\EmailConfirmation($contact);
    }

    public function sms(Contact $contact): string
    {
        $business = $contact->business;
        $incentive = $business->business_incentive;

        return "{$business->name}: Thanks for sharing your phone number. Show this to our team member to receive {$incentive->formatted()} your purchase! Reply STOP to opt out.";
    }

    public function type(): MessageType
    {
        return MessageType::Confirmation;
    }
}

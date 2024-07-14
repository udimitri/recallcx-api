<?php

namespace App\Domain\Messenger\Messages;

use App\Domain\Messenger\Message;
use App\Domain\ReactEmail\ReactMailable;
use App\Mail;
use App\Models\Contact;
use App\Models\Enums\MessageType;

class TestBroadcastMessage implements Message
{

    public function __construct(
        public string $subject,
        public string $message
    ) {
    }

    public function email(Contact $contact): ReactMailable
    {
        return new Mail\BroadcastEmail($this->subject, trim($this->message), $contact);
    }

    public function sms(Contact $contact): string
    {
        $business = $contact->business;

        return "{$business->name}: {$this->message} Reply STOP to opt out.";
    }

    public function type(): MessageType
    {
        return MessageType::Broadcast;
    }
}

<?php

namespace App\Domain\Messenger\Messages;

use App\Domain\Messenger\Message;
use App\Domain\ReactEmail\ReactMailable;
use App\Mail;
use App\Models\Broadcast;
use App\Models\Contact;
use App\Models\Enums\MessageType;

class BroadcastMessage implements Message
{

    public function __construct(
        public Broadcast $broadcast
    ) {
    }

    public function email(Contact $contact): ReactMailable
    {
        return new Mail\BroadcastEmail($this->broadcast, $contact);
    }

    public function sms(Contact $contact): string
    {
        $business = $contact->business;

        return "{$business->name}: {$this->broadcast->message}";
    }

    public function type(): MessageType
    {
        return MessageType::Broadcast;
    }
}

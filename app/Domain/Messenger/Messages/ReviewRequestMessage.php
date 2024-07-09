<?php

namespace App\Domain\Messenger\Messages;

use App\Domain\Messenger\Message;
use App\Domain\ReactEmail\ReactMailable;
use App\Mail;
use App\Models\Contact;
use App\Models\Enums\MessageType;

class ReviewRequestMessage implements Message
{

    public function email(Contact $contact): ReactMailable
    {
        return new Mail\ReviewRequest($contact);
    }

    public function sms(Contact $contact): string
    {
        $business = $contact->business;
        $review_url = "https://{$business->slug}.onrecallcx.com/review";

        return "Thanks for visiting {$business->name}! We'd love to know how we're doing. Do you have 60 seconds to leave us a quick review? {$review_url} Reply STOP to opt out.";
    }

    public function type(): MessageType
    {
        return MessageType::ReviewRequest;
    }
}

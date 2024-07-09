<?php

namespace App\Domain\DTOs;

use App\Models\Contact;
use App\Models\Enums\ContactType;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class ContactDto implements Arrayable
{
    public function __construct(
        private int $id,
        private ContactType $channel,
        private string $value,
        private ?Carbon $review_request_sent_at,
        private Carbon $created_at,
        private ?Carbon $unsubscribed_at
    ) {

    }

    public static function fromContact(Contact $contact)
    {
        return new self(
            $contact->id,
            $contact->channel,
            $contact->value,
            $contact->review_request_sent_at,
            $contact->created_at,
            $contact->unsubscribed_at,
        );
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}

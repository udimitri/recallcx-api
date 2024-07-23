<?php

namespace App\Domain\DTOs;

use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class ReviewRequestDto implements Arrayable
{
    public function __construct(
        private string $value,
        private ?Carbon $review_request_sent_at,
    ) {

    }

    public static function fromContact(Contact $contact)
    {
        return new self(
            $contact->value,
            $contact->review_request_sent_at,
        );
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}

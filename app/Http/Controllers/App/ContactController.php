<?php

namespace App\Http\Controllers\App;

use App\Domain\DTOs\ContactDto;
use App\Domain\DTOs\ReviewRequestDto;
use App\Models\Business;
use App\Models\Contact;

class ContactController
{
    public function list(Business $business)
    {
        return $business->contacts()
            ->orderByDesc('created_at')
            ->jsonPaginate()
            ->through(fn (Contact $contact) => ContactDto::fromContact($contact));
    }

    public function reviewRequestHistory(Business $business)
    {
        return $business
            ->contacts()
            ->orderByDesc('review_request_sent_at')
            ->jsonPaginate()
            ->through(fn (Contact $contact) => ReviewRequestDto::fromContact($contact));
    }
}

<?php

namespace App\Http\Controllers\App;

use App\Domain\DTOs\ContactDto;
use App\Domain\DTOs\ReviewRequestDto;
use App\Domain\Reporting\Last7Report\AudienceLast7Report;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use Illuminate\Http\JsonResponse;

class ContactController
{
    public function overview(Business $business): JsonResponse
    {
        return response()->json([
            'metrics' => [
                'total' => $business->contacts()->count(),
                'email' => $business->contacts()->where('channel', ContactType::Email)->count(),
                'phone' => $business->contacts()->where('channel', ContactType::Phone)->count(),
                'unsubscribed' => $business->contacts()->whereNotNull('unsubscribed_at')->count(),
            ],
            'last7' => (new AudienceLast7Report($business))->get()
        ]);
    }

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
            ->whereNotNull('review_request_sent_at')
            ->orderByDesc('review_request_sent_at')
            ->jsonPaginate()
            ->through(fn (Contact $contact) => ReviewRequestDto::fromContact($contact));
    }
}

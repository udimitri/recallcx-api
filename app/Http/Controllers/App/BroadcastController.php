<?php

namespace App\Http\Controllers\App;

use App\Domain\DTOs\BroadcastDto;
use App\Domain\Messenger\Messages\TestBroadcastMessage;
use App\Domain\Messenger\Messenger;
use App\Domain\Twilio\LookupClient;
use App\Http\Requests\CreateBroadcastRequest;
use App\Http\Requests\SendTestBroadcastRequest;
use App\Models\Broadcast;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\BroadcastStatus;
use App\Models\Enums\ContactType;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BroadcastController
{
    public function __construct(
        private LookupClient $lookupClient,
        private Messenger $messenger
    ) {
    }

    public function list(Business $business)
    {
        return $business->broadcasts()
            ->orderByDesc('created_at')
            ->jsonPaginate()
            ->through(fn (Broadcast $broadcast) => BroadcastDto::fromBroadcast($broadcast));
    }

    public function get(Business $business, Broadcast $broadcast): JsonResponse
    {
        return response()->json([
            'broadcast' => BroadcastDto::fromBroadcast($broadcast)->toArray(),
        ]);
    }


    public function store(Business $business, CreateBroadcastRequest $request): JsonResponse
    {
        $broadcast = $business->broadcasts()->create([
            'status' => BroadcastStatus::Created,
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'send_at' => (new Carbon($request->input('send_at'), "America/Edmonton"))->utc()
        ]);

        return response()->json([
            'broadcast' => BroadcastDto::fromBroadcast($broadcast)->toArray(),
        ]);
    }


    public function sendTestMessage(Business $business, SendTestBroadcastRequest $request): Response
    {
        $formatted_phone_number = $this->lookupClient->format($request->input('phone_number'));

        $email_contact = Contact::build($business, ContactType::Email, $request->input('email_address'), return_existing: true);
        $phone_contact = Contact::build($business, ContactType::Phone, $formatted_phone_number, return_existing: true);

        $message = new TestBroadcastMessage(
            $request->input('subject'),
            $request->input('message')
        );

        $this->messenger->send($email_contact, $message);
        $this->messenger->send($phone_contact, $message);

        return response()->noContent();
    }
}

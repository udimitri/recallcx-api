<?php

namespace App\Http\Controllers\App;

use App\Domain\DTOs\ContactDto;
use App\Domain\Messenger\Messages\TestBroadcastMessage;
use App\Domain\Messenger\Messenger;
use App\Domain\Twilio\LookupClient;
use App\Http\Requests\CreateBroadcastRequest;
use App\Http\Requests\SendTestBroadcastRequest;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\BroadcastStatus;
use App\Models\Enums\ContactType;
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
            ->through(fn (Contact $contact) => ContactDto::fromContact($contact));
    }

    public function store(Business $business, CreateBroadcastRequest $request): Response
    {
        // TODO: remove channel
        $business->broadcasts()->create([
            'status' => BroadcastStatus::Created,
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'send_at' => $request->input('send_at')
        ]);

        return response()->noContent();
    }


    public function sendTestMessage(Business $business, SendTestBroadcastRequest $request): Response
    {
        $formatted_phone_number = $this->lookupClient->format($request->input('phone_number'));

        $email_contact = Contact::build($business, ContactType::Email, $request->input('email_address'));
        $phone_contact = Contact::build($business, ContactType::Phone, $formatted_phone_number);

        $message = new TestBroadcastMessage(
            $request->input('subject'),
            $request->input('message')
        );

        $this->messenger->send($email_contact, $message);
        $this->messenger->send($phone_contact, $message);

        return response()->noContent();
    }
}

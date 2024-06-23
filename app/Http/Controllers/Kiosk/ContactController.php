<?php

namespace App\Http\Controllers\Kiosk;

use App\Domain\Base64URL;
use App\Domain\Twilio\LookupClient;
use App\Http\Requests\CreateContactRequest;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController
{
    public function __construct(
        private LookupClient $lookupClient
    ) {
    }

    public function store(Business $business, CreateContactRequest $request): Response
    {
        $value = match ($request->type()) {
            ContactType::Email => $request->input('email_address'),
            ContactType::Phone => $this->lookupClient->format($request->input('phone_number')),
        };

        $contact = Contact::build($business, $request->type(), $value);

        $contact->transport()->sendConfirmation();

        return response()->noContent();
    }

    public function unsubscribe(Business $business, Request $request): Response
    {
        $decoded_email = Base64URL::decode($request->input('encoded_email'));

        $contact = $business->contacts()
            ->where('channel', ContactType::Email)
            ->where('value', $decoded_email)
            ->first();

        // if the contact doesn't exist, that's ok
        // they're not going to get emails
        $contact?->unsubscribe();

        return response()->noContent();
    }
}

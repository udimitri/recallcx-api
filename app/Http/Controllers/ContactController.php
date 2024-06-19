<?php

namespace App\Http\Controllers;

use App\Domain\Base64URL;
use App\Domain\Twilio\LookupClient;
use App\Http\Requests\StoreContactRequest;
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

    public function store(Business $business, StoreContactRequest $request): Response
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
            ->firstOrFail();

        $contact->unsubscribe();

        return response()->noContent();
    }
}

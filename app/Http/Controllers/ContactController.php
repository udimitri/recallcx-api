<?php

namespace App\Http\Controllers;

use App\Domain\Twilio\LookupClient;
use App\Domain\Twilio\TwilioClientFactory;
use App\Http\Requests\StoreContactRequest;
use App\Models\Business;
use App\Models\Contact;
use App\Models\ContactType;
use Illuminate\Http\Response;

class ContactController
{
    public function __construct(private LookupClient $lookupClient)
    {
    }

    public function store(Business $business, StoreContactRequest $request): Response
    {
        $client = TwilioClientFactory::get($business);

        $value = match ($request->type()) {
            ContactType::Email => $request->input('email_address'),
            ContactType::Phone => $this->lookupClient->format($client, $request->input('phone_number')),
        };

        Contact::build($business, $request->type(), $value);

        return response()->noContent();
    }
}

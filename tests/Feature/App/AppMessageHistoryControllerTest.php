<?php

use App\Models\Business;
use App\Models\Contact;
use App\Models\ContactMessageHistory;
use App\Models\Enums\ContactType;
use App\Models\Enums\MessageType;

beforeEach(function () {
    $this->actingAs($this->unitTestUser());
});

it('can list message history', function (Business $business) {
    $other_unowned_business = Business::build('biz-b', 'Business B', [
        'twilio_account_id' => 'test2',
        'twilio_messaging_service_id' => 'test2',
        'google_review_url' => 'https://google.com/test2',
        'owner_id' => 'other_user_test'
    ]);

    $contact1 = Contact::build($business, ContactType::Email, 'dimitri+test1@recallcx.com');
    $contact2 = Contact::build($other_unowned_business, ContactType::Email, 'dtrofimuk@gmail.com');
    $contact3 = Contact::build($business, ContactType::Phone, '+17809103702');
    $contact4 = Contact::build($other_unowned_business, ContactType::Phone, '+17804373705');

    $history1 = ContactMessageHistory::build($contact1, MessageType::Confirmation, null, "Test", "Test message");
    $history2 = ContactMessageHistory::build($contact2, MessageType::Confirmation, null, "Test", "Test message");
    $history3 = ContactMessageHistory::build($contact3, MessageType::Confirmation, null, null, "Test message");
    $history4 = ContactMessageHistory::build($contact4, MessageType::Confirmation, null, null, "Test message");

    $response = $this->getJson("/api/app/businesses/{$business->slug}/messages")
        ->assertOk()
        ->assertJsonStructure([
            "current_page",
            "data" => [
                [
                    "id",
                    "contact_id",
                    "type",
                    "broadcast_id",
                    "subject",
                    "message",
                    "created_at"
                ]
            ],
            "from",
            "to",
            "total"
        ])
        ->json();

    $ids = collect($response['data'])->pluck('id')->all();

    expect($ids)->toBe([
        $history1->id,
        $history3->id,
    ]);
})->with('business');

<?php

use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactType;

beforeEach(function () {
    $this->actingAs($this->unitTestUser());
});

it('can list contacts', function (Business $business) {
    $other_unowned_business = Business::build('biz-b', 'Business B', [
        'twilio_account_id' => 'test2',
        'twilio_messaging_service_id' => 'test2',
        'google_review_url' => 'https://google.com/test2',
        'owner_id' => 'other_user_test'
    ]);

    $contact1 = Contact::build($business, ContactType::Email, 'dimitri+test1@recallcx.com');
    $contact2 = Contact::build($other_unowned_business, ContactType::Email, 'dtrofimuk@gmail.com');
    $contact3 = Contact::build($business, ContactType::Email, 'dimitri+test2@recallcx.com');
    $contact4 = Contact::build($business, ContactType::Phone, '+17809103702');
    $contact5 = Contact::build($business, ContactType::Email, 'dimitri+test4@recallcx.com');
    $contact6 = Contact::build($other_unowned_business, ContactType::Phone, '+17804373705');

    $response = $this->getJson("/api/app/businesses/{$business->slug}/contacts")
        ->assertOk()
        ->assertJsonStructure([
            "current_page",
            "data" => [
                [
                    "id",
                    "channel",
                    "value",
                    "review_request_sent_at",
                    "created_at",
                    "unsubscribed_at"
                ]
            ],
            "from",
            "to",
            "total"
        ])
        ->json();

    $ids = collect($response['data'])->pluck('id')->all();

    expect($ids)->toBe([
        $contact1->id,
        $contact3->id,
        $contact4->id,
        $contact5->id,
    ]);
})->with('business');

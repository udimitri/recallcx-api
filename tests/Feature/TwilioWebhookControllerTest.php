<?php

use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactStatus;
use App\Models\Enums\ContactType;

describe('it can handle twilio webhooks', function () {

    it('can handle stop word messages and unsubscribe user', function (Business $business) {
        $contact = Contact::build($business, ContactType::Phone, '+17809103702');

        expect($contact->unsubscribed_at)->toBeNull()
            ->and($contact->status())->toBe(ContactStatus::Subscribed);

        $this->postJson("/api/webhook/twilio", [
            'AccountSid' => 'test',
            'From' => '+17809103702',
            'Body' => 'stop'
        ])
            ->assertOk()
            ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
            ->assertContent("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<Response/>\n");

        $contact->refresh();

        expect($contact->unsubscribed_at)->not()->toBeNull()
            ->and($contact->status())->toBe(ContactStatus::Unsubscribed);
    })->with('business');

    it('can handle non-stop word messages', function (Business $business) {
        $contact = Contact::build($business, ContactType::Phone, '+17809103702');

        $this->postJson("/api/webhook/twilio", [
            'AccountSid' => 'test',
            'From' => '+17809103702',
            'Body' => 'ok'
        ])
            ->assertOk()
            ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
            ->assertContent("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<Response/>\n");

        expect(Contact::find($contact->id))->not()->toBeNull();
    })->with('business');

    it('can ignores unknown contacts', function (Business $business) {
        // non-stop words don't 404
        $this->postJson("/api/webhook/twilio", [
            'AccountSid' => 'test',
            'From' => '+17809103702',
            'Body' => 'stop'
        ])
            ->assertNotFound();
    })->with('business');
});

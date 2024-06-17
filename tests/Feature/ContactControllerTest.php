<?php

use App\Models\Business;
use App\Models\Contact;
use App\Models\ContactType;

describe('it can store contacts', function () {

    it('can store an email contact', function () {
        $business = Business::build('biz-a', 'Business A');

        $this->postJson("/api/businesses/{$business->id}/contacts", [
            "email_address" => "dimitri@recallcx.com"
        ]);

        $result = Contact::query()->where([
            'business_id' => $business->id,
            'channel' => ContactType::Email,
            'value' => 'dimitri@recallcx.com'
        ])->first();

        expect($result)->not()->toBeNull();
    });

    it('can store a phone contact', function () {
        $business = Business::build('biz-a', 'Business A');

        $this->postJson("/api/businesses/{$business->id}/contacts", [
            "phone_number" => "780 910-3702"
        ]);

        // the stored phone number should be formatted
        // in international format
        $result = Contact::query()->where([
            'business_id' => $business->id,
            'channel' => ContactType::Phone,
            'value' => '+17809103702'
        ])->first();

        expect($result)->not()->toBeNull();
    });

    it('cannot store an email contact twice', function () {
        $business = Business::build('biz-a', 'Business A');

        Contact::build($business, ContactType::Email, "dimitri@recallcx.com");

        $this->postJson("/api/businesses/{$business->id}/contacts", [
            "email_address" => "dimitri@recallcx.com"
        ])->assertConflict();
    });

    it('cannot store a phone contact twice', function () {
        $business = Business::build('biz-a', 'Business A');

        Contact::build($business, ContactType::Email, "+17809103702");

        $this->postJson("/api/businesses/{$business->id}/contacts", [
            "phone_number" => "7809103702"
        ])->assertConflict();
    });
});

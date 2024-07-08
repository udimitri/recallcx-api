<?php

use App\Domain\Twilio\SmsClient;
use App\Mail\EmailConfirmation;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactStatus;
use App\Models\Enums\ContactType;
use App\Models\Enums\MessageType;
use App\Models\UnsubscribeLog;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Tests\Stubs\StubLookupClient;

describe('it can store contacts', function () {

    it('can store an email contact and send confirmation email', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/kiosk/businesses/{$business->slug}/contacts", [
            "email_address" => "dimitri@recallcx.com"
        ])->assertNoContent();

        $result = Contact::query()->where([
            'business_id' => $business->id,
            'channel' => ContactType::Email,
            'value' => 'dimitri@recallcx.com'
        ])->first();

        expect($result)->not()->toBeNull();

        expect($result->messages()->where('message_type', MessageType::Confirmation)->count())
            ->toBe(1);

        Mail::assertSentCount(1);
        Mail::assertSent(EmailConfirmation::class, function (EmailConfirmation $mail) {
            return $mail->assertTo('dimitri@recallcx.com');
        });
    })->with('business');

    it('can store a phone contact and send confirmation text', function (Business $business) {
        $this->mock(SmsClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')
                ->with(
                    Mockery::on(fn (Contact $contact) => $contact->value === '+17809103702'),
                    'Business A: Thanks for sharing your phone number. Show this to our team member to receive $5 off your purchase! Reply STOP to opt out.'
                );
        });

        StubLookupClient::registerFormatted("780 910-3702", "+17809103702");
        StubLookupClient::registerValid("780 910-3702", true);

        $this->postJson("/api/kiosk/businesses/{$business->slug}/contacts", [
            "phone_number" => "780 910-3702"
        ])->assertNoContent();

        // the stored phone number should be formatted
        // in international format
        $result = Contact::query()->where([
            'business_id' => $business->id,
            'channel' => ContactType::Phone,
            'value' => '+17809103702'
        ])->first();

        expect($result)->not()->toBeNull();

        expect($result->messages()->where('message_type', MessageType::Confirmation)->count())
            ->toBe(1);
    })->with('business');

    it('cannot store an email contact twice', function (Business $business) {
        Mail::fake();

        Contact::build($business, ContactType::Email, "dimitri@recallcx.com");

        $this->postJson("/api/kiosk/businesses/{$business->slug}/contacts", [
            "email_address" => "dimitri@recallcx.com"
        ])->assertConflict();

        Mail::assertNothingSent();
    })->with('business');

    it('cannot store a phone contact twice', function (Business $business) {
        $this->mock(SmsClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')->never();
        });

        Contact::build($business, ContactType::Phone, "+17809103702");

        StubLookupClient::registerFormatted("7809103702", "+17809103702");
        StubLookupClient::registerValid("7809103702", true);

        $this->postJson("/api/kiosk/businesses/{$business->slug}/contacts", [
            "phone_number" => "7809103702"
        ])->assertConflict();
    })->with('business');

    it('can unsubscribe from email', function (Business $business) {
        Mail::fake();

        $contact = Contact::build($business, ContactType::Email, "dimitri@recallcx.com");

        expect($contact->unsubscribed_at)->toBeNull()
            ->and($contact->status())->toBe(ContactStatus::Subscribed);

        $this->postJson("/api/kiosk/businesses/{$business->slug}/contacts/unsubscribe", [
            "encoded_email" => "ZGltaXRyaUByZWNhbGxjeC5jb20"
        ])->assertNoContent();

        $result = Contact::query()->where('value', 'dimitri@recallcx.com')->first();

        expect($result->unsubscribed_at)->not()->toBeNull()
            ->and($result->status())->toBe(ContactStatus::Unsubscribed);

        $result = UnsubscribeLog::query()->where('value', 'dimitri@recallcx.com')->first();

        expect($result)->not()->toBeEmpty();

        Mail::assertNothingSent();
    })->with('business');
});

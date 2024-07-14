<?php

use App\Domain\Twilio\SmsClient;
use App\Mail\BroadcastEmail;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\Channel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Tests\Stubs\StubLookupClient;

describe('it can action broadcasts', function () {

    beforeEach(function() {
        $this->actingAs($this->unitTestUser());
    });

    it('can create a broadcast', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'subject' => 'Up to 70% off this weekend!',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertNoContent();

    })->with('business');

    it('requires a subject for emails', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'subject' => '  ',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'subject' => 'required'
        ]);

    })->with('business');


    it('limits subjects to 50 characters', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'subject' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'subject' => 'subject field must not be greater than 50 characters'
        ]);

    })->with('business');

    it('limits SMS messages to 320 characters', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'message' => 'message field must not be greater than 320 characters'
        ]);

    })->with('business');

    it('requires at least 10 characters for a message', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'subject' => '70% off',
            'message' => '70% off',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'message' => 'message field must be at least 10 characters'
        ]);

    })->with('business');


    it('can send a test broadcast', function (Business $business) {
        Mail::fake();

        $this->mock(SmsClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')
                ->with(
                    Mockery::on(fn (Contact $contact) => $contact->value === '+17809103702'),
                    'Business A: Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Reply STOP to opt out.'
                );
        });

        StubLookupClient::registerFormatted("7809103702", "+17809103702");
        StubLookupClient::registerValid("7809103702", true);

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts/send-test", [
            'subject' => 'Up to 70% off this weekend!',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',

            'email_address' => 'dimitri@recallcx.com',
            'phone_number' => '7809103702',
        ])->assertNoContent();

        Mail::assertSentCount(1);
        Mail::assertSent(BroadcastEmail::class, function (BroadcastEmail $mail) {
            return $mail->assertTo('dimitri@recallcx.com');
        });
    })->with('business');
});

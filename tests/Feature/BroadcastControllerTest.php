<?php

use App\Models\Business;
use App\Models\Enums\Channel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

describe('it can action broadcasts', function () {

    beforeEach(function() {
        $this->actingAs($this->unitTestUser());
    });

    it('can create a broadcast', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'channel' => Channel::Email->value,
            'subject' => 'Up to 70% off this weekend!',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertNoContent();

    })->with('business');

    it('requires a subject for emails', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'channel' => Channel::Email->value,
            'subject' => '  ',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'subject' => 'required'
        ]);

    })->with('business');

    it('prohibits a subject for SMS', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'channel' => Channel::Sms->value,
            'subject' => 'Up to 70% off this weekend!',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrorFor('subject');

    })->with('business');

    it('limits subjects to 50 characters', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'channel' => Channel::Email->value,
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
            'channel' => Channel::Sms->value,
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'message' => 'message field must not be greater than 320 characters'
        ]);

    })->with('business');

    it('allows email messages to exceed 320 characters', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'channel' => Channel::Email->value,
            'subject' => 'Get up to 70% off this Friday and Saturday.',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertNoContent();

    })->with('business');

    it('limits email messages to 2000 characters', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'channel' => Channel::Email->value,
            'subject' => 'Get up to 70% off this Friday and Saturday.',
            'message' => 'Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock! Get up to 70% off this Friday and Saturday. Hurry, there is limited stock!',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'message' => 'message field must not be greater than 2000 characters'
        ]);

    })->with('business');

    it('requires at least 10 characters for a message', function (Business $business) {
        Mail::fake();

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'channel' => Channel::Sms->value,
            'message' => '70% off',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'message' => 'message field must be at least 10 characters'
        ]);

        $this->postJson("/api/app/businesses/{$business->slug}/broadcasts", [
            'channel' => Channel::Email->value,
            'subject' => '70% off',
            'message' => '70% off',
            'send_at' => Carbon::now()->toDateTimeString(),
        ])->assertJsonValidationErrors([
            'message' => 'message field must be at least 10 characters'
        ]);

    })->with('business');
});

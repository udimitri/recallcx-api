<?php

use App\Domain\Twilio\SmsClient;
use App\Mail\EmailConfirmation;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use App\Models\UnsubscribeLog;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Tests\Stubs\StubLookupClient;

describe('it can act on businesses', function () {

    it('can load a business', function (Business $business) {
        Mail::fake();

        $this->getJson("/api/kiosk/businesses/{$business->slug}")
            ->assertOk()
            ->assertJson([
                'business' => [
                    'id' => $business->id,
                    'slug' => 'biz-a',
                    'name' => 'Business A',
                    'google_review_url' => 'https://google.com/test',
                    'owner' => [
                        'first_name' => 'Ted',
                        'phone_number' => '+17809103702'
                    ]
                ]
            ])
            ->assertJsonMissingPath('business.twilio_account_id')
            ->assertJsonMissingPath('business.twilio_messaging_service_id');

    })->with('business');

    it('404s on unknown business', function (Business $business) {
        Mail::fake();

        $this->getJson("/api/kiosk/businesses/test")
            ->assertNotFound();

    })->with('business');
});

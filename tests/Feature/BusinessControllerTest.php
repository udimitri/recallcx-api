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

        $this->getJson("/api/businesses/{$business->slug}")
            ->assertOk()
        ->assertJson([
            'business' => [
                'id' => $business->id,
                'slug' => 'biz-a',
                'name' => 'Business A',
                'google_review_url' => 'https://google.com/test',
            ]
        ]);

    })->with('business');

    it('404s on unknown business', function (Business $business) {
        Mail::fake();

        $this->getJson("/api/businesses/test")
            ->assertNotFound();

    })->with('business');
});

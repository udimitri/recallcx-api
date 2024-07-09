<?php

use App\Console\Commands\SendReviewRequests;
use App\Domain\Messenger\Message;
use App\Domain\Messenger\Messages\ReviewRequestMessage;
use App\Domain\Messenger\Messenger;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Mockery\MockInterface;

describe('it can send review requests', function () {

    it('can send review requests', function (Business $business) {
        $real_now = now();

        Carbon::setTestNow($real_now->copy()->subHours(4));

        $contact1 = Contact::build($business, ContactType::Email, 'dimitri+test1@recallcx.com');
        $contact2 = Contact::build($business, ContactType::Email, 'dimitri+test2@recallcx.com');
        $contact3 = Contact::build($business, ContactType::Email, 'dimitri+test3@recallcx.com');

        Carbon::setTestNow($real_now->copy()->subHour());
        $contact4 = Contact::build($business, ContactType::Email, 'dimitri+test4@recallcx.com');

        $contact2->unsubscribe();

        Carbon::setTestNow($real_now);

        $this->mock(Messenger::class, function (MockInterface $mock) use ($contact1, $contact3) {
            $contact = fn (Contact $contact) => Mockery::on(fn (Contact $other) => $other->id === $contact->id);
            $review_request = Mockery::on(fn (Message $message) => $message instanceof ReviewRequestMessage);

            $mock->shouldReceive('send')->once()->with($contact($contact1), $review_request);
            $mock->shouldReceive('send')->once()->with($contact($contact3), $review_request);

            // contact 2 is unsubscribed and should not receive a message
            // contact 4 was only created an hour ago and should not receive a message
        });

        Artisan::call(SendReviewRequests::class);

    })->with('business');


    it('wont send duplicate on exception', function (Business $business) {
        $real_now = now();

        Carbon::setTestNow($real_now->copy()->subHours(4));

        $contact1 = Contact::build($business, ContactType::Email, 'dimitri+test1@recallcx.com');

        Carbon::setTestNow($real_now);

        $this->mock(Messenger::class, function (MockInterface $mock) {
            $mock->shouldReceive('send')->once()->andThrow(new LogicException("Error"));
        });

        Artisan::call(SendReviewRequests::class);

        expect($contact1->refresh()->review_request_sent_at)->not()->toBeNull();

    })->with('business');

});

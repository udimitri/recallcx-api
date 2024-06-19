<?php

use App\Mail\ReviewRequest;
use App\Models\Business;
use App\Models\BusinessOwner;
use App\Models\Contact;
use App\Models\Enums\ContactType;

it('can render a review request email', function () {
    $business = Business::build('biz-a', 'Business A');
    $business_owner = BusinessOwner::build($business, 'Ted');
    $contact = Contact::build($business, ContactType::Email, "dimitri@recallcx.com");

    $mailable = new ReviewRequest($contact);

    $mailable->assertFrom('updates@biz-a.onrecallcx.com', 'Ted from Business A');
    $mailable->assertHasSubject('Thanks for visiting Business A!');

    $mailable->assertSeeInHtml('Do you have 60 seconds to leave us a quick review?');
    $mailable->assertSeeInHtml('https://biz-a.onrecallcx.com/review');
    $mailable->assertSeeInHtml('https://biz-a.onrecallcx.com/unsubscribe?email=ZGltaXRyaUByZWNhbGxjeC5jb20');
});

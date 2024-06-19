<?php

use App\Mail\EmailConfirmation;
use App\Models\Business;
use App\Models\BusinessIncentive;
use App\Models\BusinessOwner;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use App\Models\Enums\IncentiveType;

it('can render a confirmation email', function () {
    $business = Business::build('biz-a', 'Business A');
    $business_owner = BusinessOwner::build($business, 'Ted');
    $business_incentive = BusinessIncentive::build($business, IncentiveType::Amount, '5');
    $contact = Contact::build($business, ContactType::Email, "dimitri@recallcx.com");

    $mailable = new EmailConfirmation($contact);

    $mailable->assertFrom('updates@biz-a.onrecallcx.com', 'Ted from Business A');
    $mailable->assertHasSubject('Here\'s $5 off your Business A purchase!');

    $mailable->assertSeeInHtml('Thanks for sharing your email! Show this email to our team member to');
    $mailable->assertSeeInHtml('$5 off');
    $mailable->assertSeeInHtml('https://biz-a.onrecallcx.com/unsubscribe?email=ZGltaXRyaUByZWNhbGxjeC5jb20');
});

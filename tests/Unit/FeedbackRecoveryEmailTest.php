<?php

use App\Mail\FeedbackRecovery;
use App\Models\Business;
use App\Models\ReviewRecovery;

it('can render a review request email', function () {
    $business = Business::build('biz-a', 'Business A');

    $message = <<<TEXT
Hi there,

I have a concern. Please get back to me as soon as possible.

Thanks!

Bob
TEXT;

    $recovery = ReviewRecovery::build($business, 'dimitri@recallcx.com', $message);

    $mailable = new FeedbackRecovery($recovery);

    $mailable->assertFrom("notifications@{$business->slug}.onrecallcx.com", "RecallCX Notifications");
    $mailable->assertHasSubject("You've received feedback from dimitri@recallcx.com");
    $mailable->assertSeeInHtml("I have a concern. Please get back to me as soon as possible.");
});

<?php

use App\Mail\EmailConfirmation;
use App\Mail\FeedbackRecovery;
use App\Models\Business;
use App\Models\ReviewRecovery;
use Illuminate\Support\Facades\Mail;

it('can handle review recovery', function (Business $business) {
    Mail::fake();

    $old_count = ReviewRecovery::query()->count();

    $this->postJson("/api/kiosk/businesses/{$business->slug}/review-recovery", [
        "email_address" => "dimitri@recallcx.com",
        "message" => <<<TXT
Hi there,

I have a concern. Please get back to me as soon as possible.

Thanks!

Bob
TXT,
    ])->assertNoContent();

    expect(ReviewRecovery::query()->count())->toBe($old_count + 1);

    Mail::assertSentCount(1);
    Mail::assertSent(EmailConfirmation::class, function (FeedbackRecovery $mail) {
        return $mail->assertTo('dimitri@recallcx.com')
            && $mail->assertSeeInHtml('I have a concern. Please get back to me as soon as possible.');
    });
})->with('business');

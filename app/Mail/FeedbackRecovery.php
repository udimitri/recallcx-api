<?php

namespace App\Mail;

use App\Domain\ReactEmail\ReactMailable;
use App\Models\ReviewRecovery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackRecovery extends ReactMailable
{
    use Queueable, SerializesModels;

    public function __construct(private ReviewRecovery $recovery)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address("notifications@{$this->recovery->business->slug}.onrecallcx.com", 'RecallCX Notifications'),
            subject: "You've received feedback from {$this->recovery->email_address}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'feedback-recovery',
            with: [
                'emailAddress' => $this->recovery->email_address,
                'message' => $this->recovery->message,
            ]
        );
    }
}

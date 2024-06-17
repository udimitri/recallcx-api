<?php

namespace App\Mail;

use App\Domain\ReactEmail\ReactMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarketingEmail extends ReactMailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Marketing Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'marketing-email',
        );
    }
}

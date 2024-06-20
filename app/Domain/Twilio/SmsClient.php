<?php

namespace App\Domain\Twilio;

use App\Models\Contact;

interface SmsClient
{
    public function send(Contact $contact, string $content): void;

}

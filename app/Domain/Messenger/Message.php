<?php

namespace App\Domain\Messenger;

use App\Models\Contact;
use App\Models\Enums\MessageType;
use Illuminate\Mail\Mailable;

interface Message
{
    public function email(Contact $contact): Mailable;

    public function sms(Contact $contact): string;

    public function type(): MessageType;
}

<?php

namespace App\Domain\Messenger;

use App\Domain\ReactEmail\ReactMailable;
use App\Models\Contact;
use App\Models\Enums\MessageType;

interface Message
{
    public function email(Contact $contact): ReactMailable;

    public function sms(Contact $contact): string;

    public function type(): MessageType;
}

<?php

namespace App\Domain\Messenger;

use App\Models\Contact;

interface Messenger
{
    public function send(Contact $contact, Message $message): void;
}

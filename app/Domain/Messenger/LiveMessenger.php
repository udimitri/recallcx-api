<?php

namespace App\Domain\Messenger;

use App\Domain\Twilio\SmsClient;
use App\Exceptions\UnsubscribedContact;
use App\Models\Contact;
use App\Models\ContactMessageHistory;
use App\Models\Enums\ContactType;
use Illuminate\Support\Facades\Mail;

class LiveMessenger implements Messenger
{
    public function __construct(
        private SmsClient $smsClient
    ) {
    }

    public function send(Contact $contact, Message $message): void
    {
        if ($contact->status()->isUnsubscribed()) {
            throw new UnsubscribedContact();
        }

        $broadcast = $message->broadcast ?? null;

        if ($contact->channel === ContactType::Phone) {
            $sms = $message->sms($contact);
            $this->smsClient->send($contact, $sms);

            ContactMessageHistory::build($contact, $message->type(), $broadcast, null, $sms);
            return;
        } else if ($contact->channel === ContactType::Email) {
            $mail = $message->email($contact);
            Mail::to($contact->value)->send($mail);

            ContactMessageHistory::build($contact, $message->type(), $broadcast, $mail->subject, $mail->render());
            return;
        }

        throw new \LogicException("Unhandled match: {$contact->channel->value}");
    }
}

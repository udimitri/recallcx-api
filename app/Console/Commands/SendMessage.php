<?php

namespace App\Console\Commands;

use App\Domain\Messenger\Messages\TestBroadcastMessage;
use App\Domain\Messenger\Messenger;
use App\Domain\Twilio\LookupClient;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use Illuminate\Console\Command;

class SendMessage extends Command
{
    protected $signature = 'app:send-message';

    protected $description = 'Send a message.';

    public function handle(LookupClient $lookupClient, Messenger $messenger)
    {
        $business = Business::where('slug', 'circularchic')->firstOrFail();

        $subject = "🛍️ 20% OFF Outerwear & Boots – This Friday & Saturday! 🛍️";
        $message = "🛍️ 20% OFF Outerwear & Boots – This Friday & Saturday! 🛍️\n\nSave 20% on all regular-priced outerwear and boots with blue/green tags!* 🧥👢 Hurry and get your fall favorites before they're gone!\n\n🗓️ This Friday & Saturday only! 🚫 Excludes fur jackets and coats. ⏳ Limited time – shop early for the best picks!";

        $this->sendTestMessage($lookupClient, $messenger, $business, $subject, $message);
    }

    private function sendTestMessage(
        LookupClient $lookupClient,
        Messenger $messenger,
        Business $business,
        string $subject,
        string $message
    ) {
        $formatted_phone_number = $lookupClient->format("+17809103702");

        $email_contact = Contact::build($business, ContactType::Email, "dimitri@recallcx.com", return_existing: true);
        $phone_contact = Contact::build($business, ContactType::Phone, $formatted_phone_number, return_existing: true);

        $message = new TestBroadcastMessage($subject, $message);

        $messenger->send($email_contact, $message);
        $messenger->send($phone_contact, $message);
    }
}

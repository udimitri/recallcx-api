<?php

namespace App\Console\Commands;

use App\Domain\Messenger\Messages\TestBroadcastMessage;
use App\Domain\Messenger\Messenger;
use App\Domain\Twilio\LookupClient;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\BroadcastStatus;
use App\Models\Enums\ContactType;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMessage extends Command
{
    protected $signature = 'app:send-message';

    protected $description = 'Send a message.';

    public function handle(LookupClient $lookupClient, Messenger $messenger)
    {
        $business = Business::where('slug', 'circularchic')->firstOrFail();

        $subject = "It's Day 3 of our Black Friday Sale—your last chance to save big! 🎉";
        $message = "It's Day 3 of our Black Friday Sale—your last chance to save big! 🎉 Enjoy 50% OFF storewide and 20% OFF fur coats. (*Exclusions apply.) Hurry, sale ends tonight!";

//         $this->sendTestMessage($lookupClient, $messenger, $business, $subject, $message);
         $this->sendMessage($business, $subject, $message);
    }

    private function sendMessage(Business $business, string $subject, string $message)
    {
        $business->broadcasts()->create([
            'status' => BroadcastStatus::Created,
            'subject' => $subject,
            'message' => $message,
            'send_at' => (new Carbon("2024-11-29 9:00:00", "America/Edmonton"))->utc()
        ]);
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

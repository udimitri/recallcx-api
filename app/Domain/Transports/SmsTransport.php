<?php

namespace App\Domain\Transports;

use App\Domain\Twilio\SmsClient;
use App\Exceptions\BusinessNotConfiguredForSms;
use App\Exceptions\ContactMustBeSms;
use App\Models\Contact;
use App\Models\Enums\ContactType;

class SmsTransport implements Transport
{
    public function __construct(private SmsClient $client, private Contact $contact)
    {
        if ($this->contact->channel !== ContactType::Phone) {
            throw new ContactMustBeSms();
        }

        if (!$this->contact->business->twilio_account_id || !$this->contact->business->twilio_messaging_service_id) {
            throw new BusinessNotConfiguredForSms();
        }
    }

    public function sendReviewRequest(): void
    {
        $business = $this->contact->business;
        $review_url = "https://{$business->slug}.onrecallcx.com/review";

        $message = "Thanks for visiting {$business->name}! We'd love to know how we're doing. Do you have 60 seconds to leave us a quick review? {$review_url} Reply STOP to opt out.";

        $this->sendSms($message);
    }

    public function sendConfirmation(): void
    {
        $business = $this->contact->business;
        $incentive = $business->business_incentive;

        $message = "{$business->name}: Thanks for sharing your phone number. Show this to our team member to receive {$incentive->formatted()} your purchase! Reply STOP to opt out.";

        $this->sendSms($message);
    }

    private function sendSms(string $message): void
    {
        $this->client->send($this->contact, $message);
    }
}

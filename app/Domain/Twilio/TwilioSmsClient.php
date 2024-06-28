<?php

namespace App\Domain\Twilio;

use App\Exceptions\BusinessNotConfiguredForSms;
use App\Models\Contact;
use Twilio\Rest\Client as BaseTwilioClient;

class TwilioSmsClient implements SmsClient
{
    private BaseTwilioClient $masterClient;

    public function __construct(
        string $accountId,
        string $authToken
    ) {
        $this->masterClient = new BaseTwilioClient($accountId, $authToken);
    }

    private function getBaseTwilioClientForSubaccount(string $subaccountSid): BaseTwilioClient
    {
        $subaccount = $this->masterClient->api->v2010->accounts($subaccountSid)->fetch();

        return new BaseTwilioClient(
            $subaccountSid,
            $subaccount->authToken
        );
    }

    public function send(Contact $contact, string $content): void
    {
        $business = $contact->business;

        if (!$business->twilio_account_id || !$business->twilio_messaging_service_id) {
            throw new BusinessNotConfiguredForSms();
        }

        $client = $this->getBaseTwilioClientForSubaccount($business->twilio_account_id);

        $client->messages->create($contact->value, [
            "messagingServiceSid" => $business->twilio_messaging_service_id,
            "body" => $content
        ]);
    }
}

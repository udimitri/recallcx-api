<?php

namespace App\Domain\Twilio;

use App\Models\Business;
use Twilio\Rest\Client;

class TwilioClientFactory
{


    public static function get(Business $business): Client
    {
        return new Client(
            config('services.twilio.key'),
            config('services.twilio.secret'),
        );
    }

}

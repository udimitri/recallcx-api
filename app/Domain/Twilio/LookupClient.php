<?php

namespace App\Domain\Twilio;

use Illuminate\Support\Collection;
use Twilio\Rest\Client as TwilioClient;
use Twilio\Rest\Lookups\V2\PhoneNumberInstance;

class LookupClient
{
    private Collection $cache;

    public function __construct()
    {
        $this->cache = new Collection();
    }

    public function get(TwilioClient $client, string $query): PhoneNumberInstance
    {
        if (!$this->cache->has($query)) {
            $this->cache->put($query, $client->lookups->v2->phoneNumbers($query)->fetch());
        }

        return $this->cache->get($query);
    }

    public function format(TwilioClient $client, string $query): string
    {
        return $this->get($client, $query)->phoneNumber;
    }

    public function isValid(TwilioClient $client, string $query): bool
    {
        return (bool)$this->get($client, $query)->valid;
    }
}

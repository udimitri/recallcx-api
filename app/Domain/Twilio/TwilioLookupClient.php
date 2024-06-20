<?php

namespace App\Domain\Twilio;

use Illuminate\Support\Collection;
use Twilio\Rest\Client as TwilioClient;
use Twilio\Rest\Lookups\V2\PhoneNumberInstance;

class TwilioLookupClient implements LookupClient
{
    private Collection $cache;
    private TwilioClient $client;

    public function __construct(
        string $accountId,
        string $authToken
    ) {
        $this->cache = new Collection();
        $this->client = new TwilioClient($accountId, $authToken);
    }

    private function get(string $query): PhoneNumberInstance
    {
        if (!$this->cache->has($query)) {
            $this->cache->put($query, $this->client->lookups->v2->phoneNumbers($query)->fetch());
        }

        return $this->cache->get($query);
    }

    public function format(string $query): string
    {
        return $this->get($query)->phoneNumber;
    }

    public function isValid(string $query): bool
    {
        return (bool)$this->get($query)->valid;
    }
}

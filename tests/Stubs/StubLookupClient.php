<?php

namespace Tests\Stubs;

use App\Domain\Twilio\LookupClient;
use Illuminate\Support\Collection;
use Twilio\Rest\Client as TwilioClient;
use Twilio\Rest\Lookups\V2\PhoneNumberInstance;

class StubLookupClient implements LookupClient
{
    private static array $format = [];
    private static array $valid = [];

    public static function registerFormatted(string $query, string $formatted): void
    {
        self::$format[$query] = $formatted;
    }

    public static function registerValid(string $query, bool $valid): void
    {
        self::$valid[$query] = $valid;
    }

    public function format(string $query): string
    {
        return self::$format[$query];
    }

    public function isValid(string $query): bool
    {
        return self::$valid[$query];
    }
}

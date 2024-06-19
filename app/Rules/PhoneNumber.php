<?php

namespace App\Rules;

use App\Domain\Twilio\LookupClient;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    public function __construct(private LookupClient $lookupClient)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->lookupClient->isValid($value)) {
            $fail("Oops, that phone number doesn't look right.");
        }
    }
}

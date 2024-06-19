<?php

namespace App\Domain\Twilio;

interface LookupClient
{
    public function format(string $query): string;

    public function isValid(string $query): bool;
}

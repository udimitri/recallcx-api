<?php

namespace App\Domain\Twilio;

use Illuminate\Support\Str;

class Twilio
{
    public static function isStopWord(string $message): bool
    {
        $stop_words = collect([
            'STOP',
            'STOPALL',
            'UNSUBSCRIBE',
            'CANCEL',
            'END',
            'QUIT'
        ]);

        $normalized_message = Str::of($message)->trim()->upper();

        return $stop_words->contains($normalized_message);
    }
}

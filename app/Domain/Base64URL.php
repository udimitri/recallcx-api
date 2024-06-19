<?php

namespace App\Domain;

class Base64URL
{
    public static function encode(string $string): string
    {
        return str_replace('=', '', strtr(base64_encode($string), '+/', '-_'));
    }

    public static function decode(string $string): string
    {
        $remainder = strlen($string) % 4;

        if ($remainder) {
            $padlen = 4 - $remainder;
            $string .= str_repeat('=', $padlen);
        }

        return base64_decode(strtr($string, '-_', '+/'));
    }
}

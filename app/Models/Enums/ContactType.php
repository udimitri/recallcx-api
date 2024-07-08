<?php

namespace App\Models\Enums;

enum ContactType: string
{
    case Email = 'email';
    case Phone = 'phone';

    public function isPhone(): bool
    {
        return $this == self::Phone;
    }

    public function isEmail(): bool
    {
        return $this == self::Email;
    }
}

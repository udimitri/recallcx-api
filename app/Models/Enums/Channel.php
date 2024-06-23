<?php

namespace App\Models\Enums;

enum Channel: string
{
    case Email = 'email';
    case Sms = 'sms';
}

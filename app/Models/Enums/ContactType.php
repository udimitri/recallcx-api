<?php

namespace App\Models\Enums;

enum ContactType: string
{
    case Email = 'email';
    case Phone = 'phone';
}

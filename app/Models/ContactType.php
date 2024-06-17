<?php

namespace App\Models;

enum ContactType: string
{
    case Email = 'email';
    case Phone = 'phone';
}

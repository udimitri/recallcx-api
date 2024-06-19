<?php

namespace App\Models\Enums;

enum IncentiveType: string
{
    case Amount = 'amount';
    case Percent = 'percent';
}

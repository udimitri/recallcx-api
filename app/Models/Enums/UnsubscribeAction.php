<?php

namespace App\Models\Enums;

enum UnsubscribeAction: string
{
    case Resubscribe = 'resubscribe';
    case Unsubscribe = 'unsubscribe';
}

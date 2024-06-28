<?php

namespace App\Models\Enums;

enum ContactStatus: string
{
    case Subscribed = 'subscribed';
    case Unsubscribed = 'unsubscribed';

    public function isUnsubscribed(): bool
    {
        return $this === self::Unsubscribed;
    }
}

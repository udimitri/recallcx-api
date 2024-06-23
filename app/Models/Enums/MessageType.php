<?php

namespace App\Models\Enums;

enum MessageType: string
{
    case Confirmation = 'confirmation';
    case ReviewRequest = 'review_request';
    case Broadcast = 'broadcast';
}

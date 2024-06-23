<?php

namespace App\Models\Enums;

enum BroadcastStatus: string
{
    case Created = 'created';
    case Sending = 'sending';
    case Finished = 'finished';
}

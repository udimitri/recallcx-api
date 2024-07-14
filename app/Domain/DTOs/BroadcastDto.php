<?php

namespace App\Domain\DTOs;

use App\Models\Broadcast;
use App\Models\Enums\BroadcastStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class BroadcastDto implements Arrayable
{
    public function __construct(
        private int $id,
        private BroadcastStatus $status,
        private string $subject,
        private string $message,
        private Carbon $send_at,
        private Carbon $created_at,
    ) {

    }

    public static function fromBroadcast(Broadcast $broadcast)
    {
        return new self(
            $broadcast->id,
            $broadcast->status,
            $broadcast->subject,
            $broadcast->message,
            $broadcast->send_at,
            $broadcast->created_at,
        );
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}

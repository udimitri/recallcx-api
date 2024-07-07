<?php

namespace App\Domain\DTOs;

use App\Models\ContactMessageHistory;
use App\Models\Enums\MessageType;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class MessageHistoryDto implements Arrayable
{
    public function __construct(
        private int $id,
        private int $contact_id,
        private MessageType $type,
        private ?int $broadcast_id,
        private ?string $subject,
        private string $message,
        private Carbon $created_at,
    ) {

    }

    public static function fromHistory(ContactMessageHistory $history)
    {
        return new self(
            $history->id,
            $history->contact_id,
            $history->message_type,
            $history->broadcast_id,
            $history->subject,
            $history->message,
            $history->created_at
        );
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}

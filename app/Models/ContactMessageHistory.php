<?php

namespace App\Models;

use App\Domain\Messenger\Message;
use App\Models\Enums\MessageType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessageHistory extends Model
{

    protected $guarded = [];

    protected $table = 'contact_message_history';

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public static function build(
        Contact $contact,
        MessageType $type,
        ?Broadcast $broadcast,
        ?string $subject,
        string $message
    ) {
        return $contact->messages()->create([
            "message_type" => $type,
            "broadcast_id" => $broadcast?->id,
            "subject" => $subject,
            "message" => $message,
        ]);
    }

}

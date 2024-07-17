<?php

namespace App\Models;

use App\Models\Enums\MessageType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessageHistory extends Model
{

    protected $guarded = [];

    protected $casts = [
        'message_type' => MessageType::class,
    ];

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
        if ($contact->channel->isEmail() && !$subject) {
            throw new \LogicException("Subject expected for email contact");
        }

        if ($contact->channel->isPhone() && $subject) {
            throw new \LogicException("Subject not expected for phone contact");
        }

        return $contact->messages()->create([
            "message_type" => $type,
            "broadcast_id" => $broadcast?->id,
            "subject" => $subject,
            "message" => $message,
        ]);
    }

}

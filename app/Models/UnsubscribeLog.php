<?php

namespace App\Models;

use App\Models\Enums\ContactType;
use App\Models\Enums\UnsubscribeAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UnsubscribeLog extends Model
{

    protected $guarded = [];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    protected function casts(): array
    {
        return [
            'action' => UnsubscribeAction::class
        ];
    }

    public static function fromContact(Contact $contact): self
    {
        return $contact->business->unsubscribe_logs()->create([
            'channel' => $contact->channel,
            'value' => $contact->value,
            'action' => UnsubscribeAction::Unsubscribe,
        ]);
    }
}

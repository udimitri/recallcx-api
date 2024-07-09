<?php

namespace App\Models;

use App\Exceptions\ContactAlreadyExistsException;
use App\Models\Enums\ContactStatus;
use App\Models\Enums\ContactType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{

    protected $guarded = [];

    protected $casts = [
        'channel' => ContactType::class,
        'review_request_sent_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ContactMessageHistory::class);
    }

    public static function build(
        Business $business,
        ContactType $type,
        string $value
    ): self {
        $payload = [
            'channel' => $type,
            'value' => $value,
        ];

        $existing = $business
            ->contacts()
            ->where($payload)
            ->first();

        // we allow people who have unsubscribed to resubscribe
        // currently this allows them to get the incentive/discount
        // again, this is an edge case and we'll watch for abuse
        if ($existing && $existing->status()->isUnsubscribed()) {
            $existing->resubscribe();
            return $existing;
        } else {
            if ($existing) {
                throw new ContactAlreadyExistsException();
            }
        }

        return $business->contacts()->create($payload);
    }

    public function resubscribe(): void
    {
        UnsubscribeLog::resubscribed($this);

        $this->unsubscribed_at = null;
        $this->save();
    }

    public function unsubscribe(): void
    {
        UnsubscribeLog::fromContact($this);

        $this->unsubscribed_at = now();
        $this->save();
    }

    public function status(): ContactStatus
    {
        if ($this->unsubscribed_at !== null) {
            return ContactStatus::Unsubscribed;
        }

        return ContactStatus::Subscribed;
    }

}

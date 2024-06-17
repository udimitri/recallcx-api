<?php

namespace App\Models;

use App\Exceptions\ContactAlreadyExistsException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'channel' => ContactType::class
        ];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
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

        if ($business->contacts()->where($payload)->exists()) {
            throw new ContactAlreadyExistsException();
        }

        return $business->contacts()->create($payload);
    }
}

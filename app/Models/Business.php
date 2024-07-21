<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Business extends Model
{

    protected $guarded = [];

    protected $hidden = [
        'twilio_account_id',
        'twilio_messaging_service_id'
    ];

    public function business_owner(): HasOne
    {
        return $this->hasOne(BusinessOwner::class);
    }

    public function business_incentive(): HasOne
    {
        return $this->hasOne(BusinessIncentive::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(RatingHistory::class);
    }

    public function unsubscribe_logs(): HasMany
    {
        return $this->hasMany(UnsubscribeLog::class);
    }

    public function review_recoveries(): HasMany
    {
        return $this->hasMany(ReviewRecovery::class);
    }

    public function broadcasts(): HasMany
    {
        return $this->hasMany(Broadcast::class);
    }

    public function messages(): HasManyThrough
    {
        return $this->hasManyThrough(ContactMessageHistory::class, Contact::class);
    }

    public static function findByTwilioId(string $account_id): ?self
    {
        return self::query()
            ->where('twilio_account_id', $account_id)
            ->first();
    }

    public static function build(
        string $slug,
        string $name,
        array $params = []
    ): self {
        return self::query()->create(array_merge($params, [
            'slug' => $slug,
            'name' => $name
        ]));
    }
}

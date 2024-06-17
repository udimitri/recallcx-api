<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Business extends Model
{

    protected $guarded = [];

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

    public static function build(
        string $slug,
        string $name
    ): self {
        return self::query()->create([
            'slug' => $slug,
            'name' => $name
        ]);
    }
}

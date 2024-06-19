<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessOwner extends Model
{

    protected $guarded = [];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public static function build(Business $business, string $first_name)
    {
        return self::query()->create([
            'business_id' => $business->id,
            'first_name' => $first_name,
        ]);
    }
}

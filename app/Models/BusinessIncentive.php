<?php

namespace App\Models;

use App\Models\Enums\IncentiveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessIncentive extends Model
{

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'type' => IncentiveType::class
        ];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public static function build(Business $business, IncentiveType $type, string $value): self
    {
        return self::query()->create([
            'business_id' => $business->id,
            'type' => $type,
            'value' => $value
        ]);
    }

    public function formatted(): string
    {
        return match ($this->type) {
            IncentiveType::Amount => "$$this->value off",
            IncentiveType::Percent => "$this->value% off",
        };
    }
}

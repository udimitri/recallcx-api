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

    public static function build(
        Business $business,
        IncentiveType $type,
        string $value,
        ?string $disclaimer = null
    ): self {
        return $business->business_incentive()->create([
            'type' => $type,
            'value' => $value,
            'disclaimer' => $disclaimer
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewRecovery extends Model
{

    protected $guarded = [];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public static function build(Business $business, string $email, string $message): self
    {
        return $business->review_recoveries()->create([
            'email_address' => $email,
            'message' => $message,
        ]);
    }
}

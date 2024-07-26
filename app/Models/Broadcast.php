<?php

namespace App\Models;

use App\Models\Enums\BroadcastStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Broadcast extends Model
{

    protected $guarded = [];
    protected $casts = [
        'status' => BroadcastStatus::class,
        'send_at' => 'datetime'
    ];
    
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function audience(): HasMany
    {
        return $this->business
            ->contacts()
            ->whereNull('unsubscribed_at');
    }
}

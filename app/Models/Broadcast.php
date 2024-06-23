<?php

namespace App\Models;

use App\Models\Enums\BroadcastStatus;
use App\Models\Enums\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Broadcast extends Model
{

    protected $guarded = [];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    protected function casts(): array
    {
        return [
            'status' => BroadcastStatus::class,
            'channel' => Channel::class,
            'send_at' => 'datetime'
        ];
    }
}

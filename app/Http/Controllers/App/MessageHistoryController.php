<?php

namespace App\Http\Controllers\App;

use App\Domain\DTOs\MessageHistoryDto;
use App\Models\Business;
use App\Models\ContactMessageHistory;

class MessageHistoryController
{
    public function list(Business $business)
    {
        return $business->messages()
            ->orderByDesc('created_at')
            ->jsonPaginate()
            ->through(fn (ContactMessageHistory $history) => MessageHistoryDto::fromHistory($history));
    }
}

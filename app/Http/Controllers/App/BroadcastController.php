<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\CreateBroadcastRequest;
use App\Models\Business;
use App\Models\Enums\BroadcastStatus;
use Illuminate\Http\Response;

class BroadcastController
{
    public function store(Business $business, CreateBroadcastRequest $request): Response
    {
        $business->broadcasts()->create([
            'status' => BroadcastStatus::Created,
            'channel' => $request->input('channel'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'send_at' => $request->input('send_at')
        ]);

        return response()->noContent();
    }
}

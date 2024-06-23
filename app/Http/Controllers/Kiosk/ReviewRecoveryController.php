<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Requests\StoreReviewRecoveryRequest;
use App\Mail\FeedbackRecovery;
use App\Models\Business;
use App\Models\ReviewRecovery;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ReviewRecoveryController
{
    public function store(Business $business, StoreReviewRecoveryRequest $request): Response
    {
        // todo: refactor to async job
        $recovery = ReviewRecovery::build($business, $request->input('email_address'), $request->input('message'));

        Mail::to('dimitri@recallcx.com')
            ->send(new FeedbackRecovery($recovery));

        return response()->noContent();
    }
}

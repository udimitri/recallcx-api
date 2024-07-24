<?php

namespace App\Http\Controllers\App;

use App\Domain\Reporting\Last30Change\ReviewsLast30Change;
use App\Models\Business;
use Illuminate\Http\JsonResponse;

class ReviewController
{
    public function overview(Business $business): JsonResponse
    {
        return response()->json([
            'business' => [
                'name' => $business->name,
                'address' => $business->address,
                'rating' => $business->ratings()->latest()->first()?->rating,
                'review_count' => $business->ratings()->latest()->first()?->review_count,
            ],
            'last30' => (new ReviewsLast30Change($business))->get()
        ]);
    }
}

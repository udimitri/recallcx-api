<?php

namespace App\Http\Controllers\App;

use App\Domain\Reporting\Last7Report\ReviewsLast7Report;
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
            'last7' => (new ReviewsLast7Report($business))->get()
        ]);
    }
}

<?php

namespace App\Http\Controllers\App;

use App\Domain\Reporting\AudienceLast7Report;
use App\Domain\Reporting\ReviewsLast7Report;
use App\Models\Business;
use Illuminate\Http\JsonResponse;

class DashboardController
{
    public function dashboard(Business $business): JsonResponse
    {
        return response()->json([
            'business' => [
                'name' => $business->name,
                'address' => $business->address,
            ],
            'audience' => [
                'count' => $business->contacts()->count(),
                'last7' => (new AudienceLast7Report($business))->get(),
            ],
            'reviews' => [
                'count' => $business->ratings()->latest()->first()?->review_count,
                'last7' => (new ReviewsLast7Report($business))->get(),
            ]
        ]);
    }
}

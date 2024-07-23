<?php

namespace App\Http\Controllers\App;

use App\Domain\Reporting\Last30Change\AudienceLast30Change;
use App\Domain\Reporting\Last30Change\ReviewsLast30Change;
use App\Domain\Reporting\Last7Report\AudienceLast7Report;
use App\Domain\Reporting\Last7Report\ReviewsLast7Report;
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
                'change' => (new AudienceLast30Change($business))->get(),
                'last7' => (new AudienceLast7Report($business))->get(),
            ],
            'reviews' => [
                'count' => $business->ratings()->latest()->first()?->review_count,
                'change' =>(new ReviewsLast30Change($business))->get(),
                'last7' => (new ReviewsLast7Report($business))->get(),
            ]
        ]);
    }
}

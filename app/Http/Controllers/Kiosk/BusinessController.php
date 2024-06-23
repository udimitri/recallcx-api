<?php

namespace App\Http\Controllers\Kiosk;

use App\Models\Business;
use Illuminate\Http\JsonResponse;

class BusinessController
{
    public function get(Business $business): JsonResponse
    {
        return response()->json([
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'google_review_url' => $business->google_review_url,
                'owner' => [
                    'first_name' => $business->business_owner?->first_name,
                    'phone_number' => $business->business_owner?->phone_number,
                ]
            ],
        ]);
    }
}

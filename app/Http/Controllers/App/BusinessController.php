<?php

namespace App\Http\Controllers\App;

use App\Models\Business;
use Illuminate\Http\JsonResponse;

class BusinessController
{
    public function get(Business $business): JsonResponse
    {
        return response()->json([
            'business' => [
                'name' => $business->name,
                'address' => $business->address,
                'logo' => $business->logo,
                'owner' => [
                    'first_name' => $business->business_owner?->first_name,
                ]
            ],
        ]);
    }
}

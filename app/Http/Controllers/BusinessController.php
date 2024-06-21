<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\JsonResponse;

class BusinessController
{
    public function get(Business $business): JsonResponse
    {
        return response()->json([
            'business' => $business,
        ]);
    }
}

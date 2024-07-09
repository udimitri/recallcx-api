<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\UpdateBusinessIncentiveRequest;
use App\Models\Business;
use App\Models\BusinessIncentive;
use Illuminate\Support\Facades\DB;

class BusinessIncentiveController
{

    public function update(Business $business, UpdateBusinessIncentiveRequest $request)
    {
        DB::transaction(function () use ($business, $request) {
            $business->business_incentive()->delete();

            if ($request->isEnabled()) {
                BusinessIncentive::build(
                    $business,
                    $request->input('type'),
                    $request->input('value'),
                    $request->input('disclaimer')
                );
            }
        });

        return response()->json([
            "incentive" => $business->business_incentive->fresh(),
        ]);
    }
}

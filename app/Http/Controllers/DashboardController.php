<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;

class DashboardController
{
    public function stats(Business $business): JsonResponse
    {
        return response()->json([
            'audience' => [
                'total' => 430,
                'last30_change' => 20.1,
            ],
            'reviews' => [
                'total' => 2350,
                'last30_change' => 10.1,
            ],
            'rating' => [
                'total' => 4.5,
                'last30_change' => 0,
            ],
        ]);
    }

    public function chart(Business $business): JsonResponse
    {
        $query = function (Carbon $date) use ($business) {
            return $business->contacts()
                ->where('created_at', '>=', $date->copy()->startOfDay()->utc()->toDateTimeString())
                ->where('created_at', '<=', $date->copy()->endOfDay()->utc()->toDateTimeString())
                ->count();
        };

        $interval = CarbonPeriod::between(
            now()->setTimezone('America/Edmonton')->subDays(6),
            now()->setTimezone('America/Edmonton')
        );

        $data = collect($interval)->map(function (Carbon $date) use($query) {
            return [
                "day" => $date->format("M j"),
                "count" => $query($date)
            ];
        })->all();

        return response()->json([
            'data' => $data,
        ]);
    }
}

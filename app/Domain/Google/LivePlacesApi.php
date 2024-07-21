<?php

namespace App\Domain\Google;

use App\Models\Business;
use Illuminate\Support\Facades\Http;

class LivePlacesApi implements PlacesApi
{
    public function __construct(
        public string $key,
    ) {
    }

    public function ratingData(Business $business): PlacesRatingData
    {
        $response = Http::throw()
            ->acceptJson()
            ->asJson()
            ->get("https://places.googleapis.com/v1/places/{$business->place_id}", [
                "fields" => "rating,userRatingCount",
                "key" => $this->key,
            ])
            ->json();

        return new PlacesRatingData(
            rating: $response['rating'],
            review_count: $response['userRatingCount']
        );
    }
}

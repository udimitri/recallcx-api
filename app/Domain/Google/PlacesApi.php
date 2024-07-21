<?php

namespace App\Domain\Google;

use App\Models\Business;

interface PlacesApi
{
    public function ratingData(Business $business): PlacesRatingData;
}

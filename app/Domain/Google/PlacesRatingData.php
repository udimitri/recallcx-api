<?php

namespace App\Domain\Google;

class PlacesRatingData
{
    public function __construct(
        public readonly float $rating,
        public readonly int $review_count,
    ) {
    }
}

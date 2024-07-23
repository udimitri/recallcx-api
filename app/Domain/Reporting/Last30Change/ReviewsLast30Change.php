<?php

namespace App\Domain\Reporting\Last30Change;

use App\Models\Business;
use Carbon\CarbonInterface;

class ReviewsLast30Change extends Last30Change
{
    public function __construct(
        private Business $business
    ) {
    }

    public function query(CarbonInterface $date): int
    {
        $record = $this->business
            ->ratings()
            ->whereDate('date', '<=', $date->copy()->endOfDay()->utc())
            ->orderByDesc('date')
            ->first();

        return $record->review_count ?? 0;
    }
}

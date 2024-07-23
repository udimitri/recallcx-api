<?php

namespace App\Domain\Reporting\Last7Report;

use App\Models\Business;
use Carbon\Carbon;

class ReviewsLast7Report extends Last7Report
{
    public function __construct(
        private Business $business
    ) {
    }

    public function query(Carbon $date): int
    {
        $record = $this->business
            ->ratings()
            ->whereDate('date', '<=', $date->copy()->endOfDay()->utc())
            ->orderByDesc('date')
            ->first();

        return $record->review_count ?? 0;
    }
}

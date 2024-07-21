<?php

namespace App\Domain\Reporting;

use App\Models\Business;
use Carbon\Carbon;

class AudienceLast7Report extends Last7Report
{
    public function __construct(
        private Business $business
    ) {
    }

    public function query(Carbon $date): int
    {
        // fallback to the previous date if we're missing values for a day
        return $this->business
            ->contacts()
            ->where('created_at', '<=', $date->copy()->endOfDay()->utc()->toDateTimeString())
            ->count();
    }
}

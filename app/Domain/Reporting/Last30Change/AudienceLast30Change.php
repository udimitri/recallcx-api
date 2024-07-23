<?php

namespace App\Domain\Reporting\Last30Change;

use App\Models\Business;
use Carbon\CarbonInterface;

class AudienceLast30Change extends Last30Change
{
    public function __construct(
        private Business $business
    ) {
    }

    public function query(CarbonInterface $date): int
    {
        return $this->business
            ->contacts()
            ->whereDate('created_at', '<=', $date->copy()->endOfDay()->utc()->toDateTimeString())
            ->count();
    }
}

<?php

namespace App\Domain\Reporting\Last7Report;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

abstract class Last7Report
{
    public abstract function query(Carbon $date): int;

    public function get()
    {
        $interval = CarbonPeriod::between(
            now()->setTimezone('America/Edmonton')->subDays(6),
            now()->setTimezone('America/Edmonton')
        );

        return collect($interval)->map(fn (Carbon $date) => [
            "day" => $date->format("M j"),
            "count" => $this->query($date)
        ])->all();
    }
}

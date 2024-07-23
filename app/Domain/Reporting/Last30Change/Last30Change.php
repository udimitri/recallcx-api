<?php

namespace App\Domain\Reporting\Last30Change;

use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;

abstract class Last30Change
{
    public abstract function query(CarbonInterface $date): int;

    public function get(): int
    {
        $interval = CarbonPeriod::between(
            now()->setTimezone('America/Edmonton')->subDays(30),
            now()->setTimezone('America/Edmonton')
        );

        return $this->query($interval->getEndDate()) - $this->query($interval->getStartDate());
    }
}

<?php

namespace App\Domain\Transports;

use App\Models\Broadcast;

interface Transport
{
    public function sendReviewRequest(): void;

    public function sendConfirmation(): void;
    public function sendBroadcast(Broadcast $broadcast): void;
}

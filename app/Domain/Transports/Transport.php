<?php

namespace App\Domain\Transports;

interface Transport
{
    public function sendReviewRequest(): void;

    public function sendConfirmation(): void;
}

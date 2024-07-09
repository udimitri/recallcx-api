<?php

namespace App\Domain\Clerk;

use Illuminate\Support\Facades\Http;

class ClerkApi
{
    const API_ROOT = "https://api.clerk.com/v1";

    public function __construct(private string $token)
    {
    }

    public function jwks()
    {
        return Http::baseUrl(self::API_ROOT)
            ->withToken($this->token)
            ->asJson()
            ->get("jwks")
            ->json();
    }
}

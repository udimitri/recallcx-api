<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ContactAlreadyExistsException extends Exception
{
    public function render(): JsonResponse {
        return response()->json([
            "message" => "This contact already exists."
        ], Response::HTTP_CONFLICT);
    }
}

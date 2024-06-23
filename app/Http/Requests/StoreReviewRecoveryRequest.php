<?php

namespace App\Http\Requests;

use App\Domain\Twilio\LookupClient;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRecoveryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email_address' => [ 'required', 'string', 'email', ],
            'message' => [ 'required', 'string', ],
        ];
    }

}

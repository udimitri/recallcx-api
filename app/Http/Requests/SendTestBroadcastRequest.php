<?php

namespace App\Http\Requests;

use App\Domain\Twilio\LookupClient;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class SendTestBroadcastRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(LookupClient $lookupClient): array
    {
        return [
            'subject' => [ 'required', 'string', 'max:50' ],
            'message' => [ 'required', 'min:10', 'max:320' ],
            'email_address' => [ 'required', 'string', 'email' ],
            'phone_number' => [ 'string', new PhoneNumber($lookupClient) ],
        ];
    }

}

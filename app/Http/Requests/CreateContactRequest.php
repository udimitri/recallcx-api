<?php

namespace App\Http\Requests;

use App\Domain\Twilio\LookupClient;
use App\Models\Enums\ContactType;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
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
            'email_address' => [
                'required_without:phone_number',
                'prohibits:phone_number',
                'string',
                'email',
            ],
            'phone_number' => [
                'required_without:email_address',
                'prohibits:email_address',
                'string',
                new PhoneNumber($lookupClient)
            ],
        ];
    }

    public function type(): ContactType
    {
        return match (true) {
            $this->has('email_address') => ContactType::Email,
            $this->has('phone_number') => ContactType::Phone,
        };
    }

}

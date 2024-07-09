<?php

namespace App\Http\Requests;

use App\Models\Enums\IncentiveType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateBusinessIncentiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => [ 'required', 'nullable', new Enum(IncentiveType::class) ],
            'value' => [ 'required', 'nullable', 'string' ],
            'disclaimer' => [ 'required', 'nullable', 'string' ],
        ];
    }

    public function isEnabled(): bool
    {
        return $this->input('type') !== null;
    }
}

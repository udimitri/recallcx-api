<?php

namespace App\Http\Requests;

use App\Models\Enums\Channel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\ProhibitedIf;
use Illuminate\Validation\Rules\RequiredIf;

class CreateBroadcastRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'channel' => [
                'required',
                new Enum(Channel::class)
            ],
            'subject' => [
                new RequiredIf(fn () => $this->input('channel') === Channel::Email->value),
                new ProhibitedIf(fn () => $this->input('channel') !== Channel::Email->value),
                'string',
                'max:50'
            ],
            'message' => [
                'required',
                'min:10',
                Rule::when(
                    fn () => $this->input('channel') === Channel::Email->value,
                    'max:2000',
                    'max:320'
                ),
            ],
            'send_at' => [
                'required',
                'date_format:Y-m-d H:i:s'
            ]
        ];
    }

}

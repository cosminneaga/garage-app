<?php

namespace App\Http\Requests;

use App\Enums\Type\FileFormatType;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingClientDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user('client')->can('clientEdit', $this->route('booking'));
    }

    public function rules(): array
    {
        $mimes = FileFormatType::mergeValidation([
            FileFormatType::IMAGE,
            FileFormatType::DOCUMENT
        ]);

        return [
            'client_notes' =>   ['sometimes', 'nullable', 'string'],
            'complaint' =>      ['sometimes', 'nullable', 'string'],
            'files' =>          ['nullable', 'array'],
            'files:*' =>        ['required', 'file', $mimes, 'max:10000'],
        ];
    }
}

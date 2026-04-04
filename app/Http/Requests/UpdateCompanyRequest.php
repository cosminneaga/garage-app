<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('company-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tax_id' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
            'tax_value' => ['required', 'string', 'max:255'],
            'invoice_prefix' => ['required', 'string', 'max:255'],
        ];
    }
}

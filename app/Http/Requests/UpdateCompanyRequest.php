<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tax_id' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
            'tax_value' => ['required', 'string', 'max:255'],
            'invoice_prefix' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg,webp', 'max:5000'],
        ];
    }
}

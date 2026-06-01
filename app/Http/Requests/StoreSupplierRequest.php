<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\SupplierType;
use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'code' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', new Enum(SupplierType::class)],
            'tax_id' => ['required', 'string', 'min:5', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
            'contact.mobile' => ['required', 'string', 'min:6', 'max:40'],
            'contact.landline' => ['nullable', 'string', 'min:6', 'max:40'],
            'contact.email' => ['required', 'email', 'max:255'],
            'contact.url' => ['nullable', 'url', 'max:255'],
            'contact_info' => ['nullable', 'string', 'max:255'],
            'address.number' => ['required', 'string', 'max:10'],
            'address.street' => ['required', 'string', 'max:60'],
            'address.postcode' => ['required', 'string', 'max:20'],
            'address.country_id' => ['required', 'integer', 'exists:countries,id'],
        ];
    }
}

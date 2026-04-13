<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can(UserPermission::name(UserPermission::COMPANY, 'store'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tax_id' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
            'tax_value' => ['required', 'string', 'max:255'],
            'invoice_prefix' => ['required', 'string', 'max:255'],
            'contact.mobile' => ['required', 'string', 'min:6', 'max:40'],
            'contact.landline' => ['nullable', 'string', 'min:6', 'max:40'],
            'contact.email' => ['required', 'email', 'max:255'],
            'contact.url' => ['nullable', 'url', 'max:255'],
            'contact.info' => ['nullable', 'string', 'max:255'],
            'address.number' => ['required', 'string', 'max:10'],
            'address.street' => ['required', 'string', 'max:60'],
            'address.postcode' => ['required', 'string', 'max:20'],
            'address_country_id' => ['required', 'integer'],
            'image' => ['mimes:png,jpg,jpeg,webp', 'max:5000'],
        ];
    }
}

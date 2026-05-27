<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can(UserPermission::name(UserPermission::USER, 'store'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'max:40'],
            'password_confirmed' => ['required', 'string', 'same:password'],
            'active' => ['string'],
            'role' => ['required', new Enum(UserRole::class)],
            'contact.mobile' => ['required', 'string', 'min:6', 'max:40'],
            'contact.landline' => ['nullable', 'string', 'min:6', 'max:40'],
            'contact.email' => ['required', 'email', 'max:255'],
            'contact.url' => ['nullable', 'url', 'max:255'],
            'contact.info' => ['nullable', 'string', 'max:255'],
            'address.number' => ['required', 'string', 'max:10'],
            'address.street' => ['required', 'string', 'max:60'],
            'address.postcode' => ['required', 'string', 'max:20'],
            'address.country_id' => ['required'],
            'address.coordinates.latitude' => ['required', 'string', 'max:20'],
            'address.coordinates.longitude' => ['required', 'string', 'max:20'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg,webp', 'max:5000'],
        ];
    }
}

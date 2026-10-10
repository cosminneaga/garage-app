<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('web')->check() || Auth::guard('client')->check();
    }

    public function rules(): array
    {
        return [
            'name' =>               ['required', 'string', 'max:255'],
            'email' =>              ['required', 'email', 'max:255'],
            'image' =>              ['nullable', 'mimes:png,jpg,jpeg,webp', 'max:5000'],
            'password' =>           ['sometimes', 'nullable', 'string'],
            'password_confirmed' => ['required_with:password', 'nullable', 'string', 'same:password']
        ];
    }
}

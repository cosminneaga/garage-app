<?php

namespace App\Http\Requests;

use App\Enums\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCompanyContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasPermissionTo(UserPermission::name(UserPermission::CONTACT, 'store'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'min:6', 'max:40'],
            'landline' => ['nullable', 'string', 'min:6', 'max:40'],
            'email' => ['required', 'email', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'info' => ['nullable', 'string', 'max:255'],
        ];
    }
}

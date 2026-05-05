<?php

namespace App\Http\Requests;

use App\Enums\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $givenUser = $this->route('user');
        if (Auth::user()->id !== $givenUser->id) {
            return false;
        }

        return Auth::user()->can(UserPermission::name(UserPermission::USER, 'update'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'active' => ['string'],
            'image' => ['mimes:png,jpg,jpeg,webp', 'max:5000'],
        ];
    }
}

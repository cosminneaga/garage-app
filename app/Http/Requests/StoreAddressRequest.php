<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can(UserPermission::name(UserPermission::ADDRESS, 'store'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'string', 'max:10'],
            'street' => ['required', 'string', 'max:60'],
            'postcode' => ['required', 'string', 'max:20'],
            'extra' => ['string', 'max:255'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'coordinates.latitude' => ['required', 'string', 'max:20'],
            'coordinates.longitude' => ['required', 'string', 'max:20'],
        ];
    }
}

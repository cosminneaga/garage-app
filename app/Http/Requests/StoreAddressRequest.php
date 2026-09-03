<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::ADDRESS, 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'street_number' => ['required', 'string', 'max:10'],
            'street' => ['required', 'string', 'max:60'],
            'postcode' => ['required', 'string', 'max:20'],
            'building' => ['nullable', 'string', 'max:255'],
            'floor' => ['nullable', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:255'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'coordinates' => [config('app.env') !== 'testing' ? 'required' : 'nullable', 'array'],
            'coordinates.latitude' => [config('app.env') !== 'testing' ? 'required' : 'nullable', 'string', 'max:20'],
            'coordinates.longitude' => [config('app.env') !== 'testing' ? 'required' : 'nullable', 'string', 'max:20'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::CLIENT, 'store');
    }

    #[Override]
    protected function prepareForValidation()
    {
        $this->merge([
            'active' => (bool) $this->input('active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' =>                               ['required', 'string', 'max:60'],
            'email' =>                              ['required', 'email', 'max:80'],
            'active' =>                             ['required', 'boolean'],
            'contact.mobile' =>                     ['required', 'string', 'min:6', 'max:40'],
            'contact.landline' =>                   ['nullable', 'string', 'min:6', 'max:40'],
            'contact.email' =>                      ['required', 'email', 'max:255'],
            'contact.url' =>                        ['nullable', 'url', 'max:255'],
            'contact.info' =>                       ['nullable', 'string', 'max:255'],
            'address.street_number' =>              ['required', 'string', 'max:10'],
            'address.street' =>                     ['required', 'string', 'max:60'],
            'address.postcode' =>                   ['required', 'string', 'max:20'],
            'address.country_id' =>                 ['required', 'integer', 'exists:countries,id'],
            'address.coordinates' =>                ['sometimes', 'nullable', 'array'],
            'address.coordinates.latitude' =>       ['sometimes', 'nullable', 'string', 'max:20'],
            'address.coordinates.longitude' =>      ['sometimes', 'nullable', 'string', 'max:20'],
            'address.building' =>                   ['nullable', 'string', 'max:255'],
            'address.floor' =>                      ['nullable', 'string', 'max:255'],
            'address.unit' =>                       ['nullable', 'string', 'max:255'],
        ];
    }
}

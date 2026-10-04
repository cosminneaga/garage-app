<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Related\RelatedModel;
use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkorderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' =>                  ['required', 'string', 'max:255'],
            'technician_id' =>          ['required', 'exists:users,id'],
            'labour_rate' =>            ['sometimes', 'nullable', 'decimal:2'],
            'notes' =>                  ['sometimes', 'nullable', 'string', 'max:450'],
            'part_notes' =>             ['sometimes', 'nullable', 'string', 'max:450'],
        ];

        $parentname = $this->route()->getAction('model');
        if ($parentname === RelatedModel::COMPANY) {
            $rules['vehicle_id'] = ['required', 'integer', 'exists:vehicles,id'];
            $rules['client_id'] = ['required', 'integer', 'exists:clients,id'];
        }

        return $rules;
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests;

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
        return [
            'title' =>                  ['required', 'string', 'max:255'],
            'technician_id' =>          ['required', 'exists:users,id'],
            'labour_price_hourly' =>    ['sometimes', 'nullable', 'decimal:2'],
            'notes' =>                  ['sometimes', 'nullable', 'string', 'max:450'],
            'part_notes' =>             ['sometimes', 'nullable', 'string', 'max:450'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateWorkorderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' =>                      ['required', 'string', 'max:255'],
            'technician_id' =>              ['required', 'exists:users,id'],
            'odometer_on_start' =>          ['sometimes', 'nullable', 'integer', 'min:0', 'required_if:cancelled_at,null'],
            'odometer_on_finish' =>         ['sometimes', 'nullable', 'integer', 'min:0', 'prohibited_if:odometer_on_start,null', 'gte:odometer_on_start'],
            'labour_price_hourly' =>        ['sometimes', 'nullable', 'decimal:2'],
            'labour_total_cost' =>          ['sometimes', 'nullable', 'decimal:2'],
            'part_total_cost' =>            ['sometimes', 'nullable', 'decimal:2'],

            'notes' =>                      ['sometimes', 'nullable', 'string', 'max:450'],
            'initial_inspection_notes' =>   ['sometimes', 'nullable', 'string', 'max:450'],
            'part_notes' =>                 ['sometimes', 'nullable', 'string', 'max:450'],
            'complaint' =>                  ['sometimes', 'nullable', 'string', 'max:450'],

            'cancelled_at' =>               ['sometimes', 'nullable', 'date_format:d-m-Y H:i'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'odometer_on_start.required_if' => 'Start odometer is required',
            'odometer_on_finish.prohibited_if' => 'Finish odometer cannot be modified, cannot be less than start odometer',
        ];
    }
}

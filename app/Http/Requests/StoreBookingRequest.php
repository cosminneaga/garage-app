<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Priority;
use App\Enums\Type\ServiceType;
use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::BOOKING, 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_status_info' =>        ['sometimes', 'string', 'max:255'],
            'service_type' =>               [new Enum(ServiceType::class)],
            'priority' =>                   [new Enum(Priority::class)],
            'confirmed_at' =>               ['required', 'date_format:d-m-Y H:i'],
            'estimated_cost' =>             ['sometimes', 'nullable', 'decimal:2'],
            'estimated_duration_minutes' => ['sometimes', 'nullable', 'integer'],
            'notes' =>                      ['sometimes', 'nullable', 'string', 'max:450'],

            # relations
            'company_id' =>                 ['required', 'integer', 'exists:companies,id'],
            'client_id' =>                  ['required', 'integer', 'exists:clients,id'],
            'vehicle_id' =>                 ['required', 'integer', 'exists:vehicles,id'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Priority;
use App\Enums\Type\ServiceType;
use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::BOOKING, 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service_type' =>                   [new Enum(ServiceType::class)],
            'priority' =>                       [new Enum(Priority::class)],
            'confirmed_at' =>                   ['required', 'date_format:d-m-Y H:i'],
            'checked_in_at' =>                  ['sometimes', 'nullable', 'date_format:d-m-Y H:i', 'after_or_equal:confirmed_at', 'prohibited_if:confirmed_at,null'],
            'cancelled_at' =>                   ['sometimes', 'nullable', 'date_format:d-m-Y H:i', 'after_or_equal:confirmed_at', 'prohibited_if:confirmed_at,null'],
            'estimated_duration_minutes' =>     ['sometimes', 'nullable', 'integer'],
            'current_status_info' =>            ['sometimes', 'nullable', 'string', 'max:255'],
            'complaint' =>                      ['sometimes', 'nullable', 'string', 'max:450'],
            'notes' =>                          ['sometimes', 'nullable', 'string', 'max:450'],
            'estimated_cost' =>                 ['sometimes', 'nullable', 'decimal:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'checked_in_at.prohibited_if' => 'Cannot check in a booking has not been confirmed yet',
            'cancelled_at.prohibited_if' => 'Cannot cancel a booking has not been confirmed yet',
        ];
    }
}

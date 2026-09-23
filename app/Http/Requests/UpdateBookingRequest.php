<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Priority;
use App\Enums\Type\ServiceType;
use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'checked_in_at' =>                  ['sometimes', 'nullable', 'date_format:d-m-Y H:i', Rule::prohibitedIf(fn () => $this->route('booking')?->confirmed_at !== null && $this->input('checked_in_at') !== $this->route('booking')->checked_in_at)],
            'confirmed_at' =>                   ['sometimes', 'nullable', 'date_format:d-m-Y H:i'],
            'cancelled_at' =>                   ['sometimes', 'nullable', 'date_format:d-m-Y H:i', 'after:start', Rule::prohibitedIf(fn () => $this->route('booking')?->confirmed_at === null)],
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
            'checked_in_at.prohibited' => 'You cannot check in a booking that has already started',
            'cancelled_at.prohibited' => 'You cannot cancel a booking has not been confirmed yet',
        ];
    }
}

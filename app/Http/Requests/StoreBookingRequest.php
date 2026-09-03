<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Priority;
use App\Enums\ServiceType;
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
            'service_type' => [new Enum(ServiceType::class)],
            'priority' => [new Enum(Priority::class)],
            'appointment_start' => ['required', 'date_format:d-m-Y H:i:s'],
            'appointment_finish' => ['date_format:d-m-Y H:i:s', 'after:appointment_start'],
            'reminder_sent_at' => ['date_format:d-m-Y H:i:s', 'after:appointment_start'],
            'checked_in_at' => ['date_format:d-m-Y H:i:s', 'after:appointment_start'],
            'completed_at' => ['date_format:d-m-Y H:i:s', 'after:appointment_start'],
            'cancelled_at' => ['date_format:d-m-Y H:i:s', 'after:appointment_start'],
            'estimated_duration_minutes' => ['integer'],
            'current_status_info' => ['string', 'max:255'],
            'complaint' => ['string', 'max:450'],
            'notes' => ['string', 'max:450'],
            'estimated_cost' => ['decimal:2'],

            # relations
            'company_id' => ['required', 'integer', 'exists:company,id'],
            'client_id' => ['required', 'integer', 'exists:client,id'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicle,id'],
            'advisor_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}

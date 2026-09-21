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
            'service_type' => [new Enum(ServiceType::class)],
            'priority' => [new Enum(Priority::class)],
            'start' => ['required', 'date_format:d-m-Y H:i:s'],
            'finish' => ['date_format:d-m-Y H:i:s', 'after:start'],
            'reminder_sent_at' => ['date_format:d-m-Y H:i:s', 'after:start'],
            'checked_in_at' => ['date_format:d-m-Y H:i:s', 'after:start'],
            'completed_at' => ['date_format:d-m-Y H:i:s', 'after:start'],
            'cancelled_at' => ['date_format:d-m-Y H:i:s', 'after:start'],
            'estimated_duration_minutes' => ['integer'],
            'current_status_info' => ['string', 'max:255'],
            'complaint' => ['string', 'max:450'],
            'notes' => ['string', 'max:450'],
            'estimated_cost' => ['decimal:2'],
        ];
    }
}

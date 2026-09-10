<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\FuelType;
use App\Enums\UserPermission;
use App\Enums\VehicleStatus;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::VEHICLE, 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vin' => ['required', 'string', 'max:255', 'unique:vehicles,vin'],
            'registration' => ['required', 'string', 'max:255'],
            'fuel' => [new Enum(FuelType::class)],
            'status' => [new Enum(VehicleStatus::class)],
            'first_visit_odometer' => ['required', 'string', 'max:255'],
            'first_visit' => ['required', 'date_format:d-m-Y H:i:s'],
            'technical_notes' => ['string', 'max:600'],
            'notes' => ['string', 'max:600'],
            'diagnostic_information' => ['string', 'max:600'],

            'vehicle_make_id' => ['exists:vehicle_makes,id'],
            'vehicle_model_id' => ['exists:vehicle_models,id'],
            'vehicle_data_id' => ['exists:vehicle_data,id'],
            'vehicle_year_id' => ['exists:vehicle_years,id'],
        ];
    }
}

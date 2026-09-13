<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Type\FuelType;
use App\Enums\UserPermission;
use App\Enums\Status\VehicleStatus;
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
            'vin' =>                    ['required', 'string', 'max:255', 'unique:vehicles,vin'],
            'registration' =>           ['required', 'string', 'max:255'],
            'fuel' =>                   [new Enum(FuelType::class)],
            'status' =>                 [new Enum(VehicleStatus::class)],
            'first_visit_odometer' =>   ['required', 'integer', 'min:0', 'max:100000000000000'],
            'first_visit' =>            ['required', 'date_format:d-m-Y H:i:s'],
            'technical_notes' =>        ['nullable', 'string', 'max:600'],
            'notes' =>                  ['nullable', 'string', 'max:600'],
            'diagnostic_information' => ['nullable', 'string', 'max:600'],

            'vehicle_make_id' =>        ['nullable', 'exists:vehicle_makes,id'],
            'vehicle_model_id' =>       ['nullable', 'exists:vehicle_models,id'],
            'vehicle_data_id' =>        ['nullable', 'exists:vehicle_data,id'],
            'vehicle_year_id' =>        ['nullable', 'exists:vehicle_years,id'],
        ];
    }
}

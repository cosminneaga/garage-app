<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Status\VehicleStatus;
use App\Enums\Type\FuelType;
use App\Enums\UserPermission;
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
            'vin' =>                    ['sometimes', 'nullable', 'string', 'max:255', 'unique:vehicles,vin'],
            'registration' =>           ['required', 'string', 'max:255'],
            'fuel' =>                   [new Enum(FuelType::class)],
            'status' =>                 [new Enum(VehicleStatus::class)],
            'first_visit_odometer' =>   ['sometimes', 'nullable', 'integer', 'min:0', 'max:100000000000000'],
            'first_visit' =>            ['sometimes', 'nullable', 'date_format:d-m-Y H:i:s'],
            'technical_notes' =>        ['sometimes', 'nullable', 'string', 'max:600'],
            'notes' =>                  ['sometimes', 'nullable', 'string', 'max:600'],
            'diagnostic_information' => ['sometimes', 'nullable', 'string', 'max:600'],
            'make_id' =>                ['sometimes', 'nullable', 'exists:car_makes,id'],
            'model_id' =>               ['sometimes', 'nullable', 'exists:car_models,id'],
            'data_id' =>                ['sometimes', 'nullable', 'exists:car_data,id'],
        ];
    }
}

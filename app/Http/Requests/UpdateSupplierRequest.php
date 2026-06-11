<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\SupplierType;
use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'code' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', new Enum(SupplierType::class)],
            'tax_id' => ['required', 'string', 'min:5', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
        ];
    }
}

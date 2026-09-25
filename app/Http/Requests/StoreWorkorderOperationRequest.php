<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkorderOperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'part_id' => ['sometimes', 'nullable', 'exists:parts,id'],
            'expected_life_km' => ['sometimes', 'nullable', 'integer'],
            'expected_life_months' => ['sometimes', 'nullable', 'integer'],
            'notes' => ['sometimes', 'nullable', 'string', 'max:450'],
        ];
    }
}

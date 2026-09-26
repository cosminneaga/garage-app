<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Type\WorkorderOperationType;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Override;

class StoreWorkorderOperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'store');
    }

    #[Override]
    protected function prepareForValidation()
    {
        if (!$this->user()->hasAnyRole([UserRole::ADMINISTRATOR, UserRole::MANAGER])) {
            $this->merge([
                'performed_by' => $this->user()->id,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' =>                   ['required', new Enum(WorkorderOperationType::class)],
            'part_id' =>                ['sometimes', 'nullable', 'exists:parts,id'],
            'expected_life_km' =>       ['sometimes', 'nullable', 'integer'],
            'expected_life_months' =>   ['sometimes', 'nullable', 'integer'],
            'notes' =>                  ['sometimes', 'nullable', 'string', 'max:450'],
            'performed_by' =>           ['required', 'integer', 'exists:users,id'],
        ];
    }
}

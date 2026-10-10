<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::CLIENT, 'update');
    }

    #[Override]
    protected function prepareForValidation()
    {
        $this->merge([
            'active' => (bool) $this->input('active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' =>       ['required', 'string', 'max:100'],
            'email' =>      ['required', 'email', 'max:255'],
            'active' =>     ['required', 'boolean'],
        ];
    }
}

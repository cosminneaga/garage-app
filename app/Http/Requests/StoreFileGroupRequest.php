<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Type\FileFormatType;
use App\Enums\Type\FileType;
use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreFileGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::FILE, 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        $mimes = FileFormatType::mergeValidation([FileFormatType::IMAGE, FileFormatType::DOCUMENT, FileFormatType::VIDEO]);

        return [
            'type' =>           ['required', new Enum(FileType::class)],
            'description' =>    ['sometimes', 'nullable', 'string', 'max:450'],
            'files' =>          ['nullable', 'array'],
            'files.*' =>        ['required', 'file', $mimes, 'max:25000'],
        ];
    }
}

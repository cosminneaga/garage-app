<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use App\Enums\Status\InvoiceStatus;
use App\Enums\UserPermission;
use App\Helpers\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Permission::can(UserPermission::INVOICE, 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' =>             ['sometimes', 'nullable', new Enum(InvoiceStatus::class)],
            'due_date' =>           ['sometimes', 'nullable', 'date_format:d-m-Y H:i'],
            'payment_method' =>     ['sometimes', 'nullable', new Enum(PaymentMethod::class)],
            'notes' =>              ['sometimes', 'nullable', 'string', 'max:450'],
            'subtotal' =>           ['sometimes', 'nullable', 'decimal:2'],
            'tax_amount' =>         ['sometimes', 'nullable', 'decimal:2'],
            'discount' =>           ['sometimes', 'nullable', 'decimal:2'],
            'total' =>              ['sometimes', 'nullable', 'decimal:2'],
            'amount_due' =>         ['sometimes', 'nullable', 'decimal:2'],
            'amount_paid' =>        ['sometimes', 'nullable', 'decimal:2'],
        ];
    }
}

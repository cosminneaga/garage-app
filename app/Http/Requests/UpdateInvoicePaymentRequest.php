<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateInvoicePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        # using policy "update" method
        return $this->user()->can('update', $this->route('invoice'));
    }

    public function validationData(): array
    {
        $data = $this->input('invoice');

        return [
            'method' => PaymentMethod::tryFrom($data['method']),
            'value' => (float) $data['value'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        $amount_due = (float) $this->route('invoice')->amount_due;

        return [
            'method' => ['required', new Enum(PaymentMethod::class)],
            'value' => ['required', 'decimal:0,2', 'lte:'.$amount_due],
        ];
    }

    public function messages(): array
    {
        return [
            'value.lte' => 'The refund value cannot be greater than invoice amount that is due',
        ];
    }
}

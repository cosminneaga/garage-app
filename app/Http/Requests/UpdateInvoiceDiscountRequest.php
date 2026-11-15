<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceDiscountRequest extends FormRequest
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

        return [...$data];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'discount' => ['required', 'decimal:2'],
        ];
    }
}

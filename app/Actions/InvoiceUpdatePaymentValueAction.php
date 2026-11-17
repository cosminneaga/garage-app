<?php

namespace App\Actions;

use App\Enums\PaymentMethod;
use App\Enums\Status\InvoiceStatus;
use App\Enums\Type\TransactionType;
use App\Models\Invoice;
use Illuminate\Support\Carbon;

class InvoiceUpdatePaymentValueAction
{
    public function __construct(protected Invoice $invoice)
    {
        //
    }

    public function handle(PaymentMethod $method, float $value): void
    {
        $currentAmountDue = (float) $this->invoice->amount_due;

        if ($value < $currentAmountDue) {
            $this->invoice->amount_due = $currentAmountDue - $value;
            $this->invoice->status = InvoiceStatus::PAID_PARTIALLY;
        } else {
            $this->invoice->amount_due = 0.00;
            $this->invoice->status = InvoiceStatus::PAID;
        }

        $this->invoice->paid_at = Carbon::now()->format('d-m-Y H:i');
        $this->invoice->update();

        $this->invoice->transactions()->create([
            'type' => TransactionType::PAYMENT,
            'method' => $method,
            'value' => $value,
        ]);
    }
}

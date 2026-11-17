<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\PaymentMethod;
use App\Enums\Status\InvoiceStatus;
use App\Enums\Type\TransactionType;
use App\Models\Invoice;

class InvoiceUpdateRefundValueAction
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
            $this->invoice->status = InvoiceStatus::REFUNDED_PARTIALLY;
        } else {
            $this->invoice->amount_due = 0.00;
            $this->invoice->status = InvoiceStatus::REFUNDED;
        }

        $this->invoice->update();

        $this->invoice->transactions()->create([
            'type' => TransactionType::REFUND,
            'method' => $method,
            'value' => $value,
        ]);
    }
}


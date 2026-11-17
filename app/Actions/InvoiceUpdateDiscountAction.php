<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\PaymentMethod;
use App\Enums\Type\TransactionType;
use App\Helpers\MathPercentage;
use App\Models\Invoice;

class InvoiceUpdateDiscountAction
{
    public function __construct(protected Invoice $invoice)
    {
        //
    }

    public function handle(float $discount): void
    {
        $this->invoice->discount = $discount;
        $this->invoice->amount_due = MathPercentage::decrease((float) $this->invoice->amount_due, $discount);
        $this->invoice->update();

        $this->invoice->transactions()->create([
            'type' => TransactionType::DISCOUNT,
            'method' => PaymentMethod::PERCENTAGE,
            'value' => $discount,
        ]);
    }
}


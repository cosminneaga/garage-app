<?php

declare(strict_types=1);

namespace App\Actions;

use App\Helpers\Math;
use App\Models\Invoice;

class InvoiceUpdateDiscountAction
{
    public function __construct(protected Invoice $invoice)
    {
        //
    }

    public function handle(float $discount): void
    {
        $this->invoice->subtotal = Math::decrease((float) $this->invoice->subtotal, $discount);
        $this->invoice->discount = $discount;
        $this->invoice->total = Math::increase((float) $this->invoice->subtotal, (float) $this->invoice->tax_amount);
        $this->invoice->amount_due = $this->invoice->total;
        $this->invoice->update();
    }
}

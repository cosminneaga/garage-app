<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Status\InvoiceStatus;
use App\Models\Invoice;
use App\Traits\ObserverHelper;
use Illuminate\Support\Carbon;

class InvoiceObserver
{
    use ObserverHelper;

    public function created(Invoice $invoice): void
    {
        if ($invoice->booking) {
            $invoice->booking->completed_at = Carbon::now()->format('d-m-Y H:i');
            $invoice->booking->save();
        }
    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        # ISSUED
        if ($this->columnInsertCheck($invoice, 'due_date')) {
            $invoice->status = InvoiceStatus::ISSUED;
            $invoice->issued_at = Carbon::now()->format('d-m-Y H:i');
            $invoice->statuses()->create([
                'status' => $invoice->status,
                'description' => 'Status was trigger by populating "due_date" field with: ' . $invoice->due_date,
            ]);
            $invoice->saveQuietly();
        }

        # PAID_PARTIALLY / PAID / REFUNDED
        if ($this->columnChangeCheck($invoice, 'amount_paid')) {
            if ($invoice->amount_paid < $invoice->amount_due) {
                $invoice->status = InvoiceStatus::PAID_PARTIALLY;
            }

            if ($invoice->amount_paid === $invoice->amount_due) {
                $invoice->status = InvoiceStatus::PAID;
            }

            if (($invoice->amount_paid < $invoice->getOriginal('amount_paid')) && $invoice->amount_paid === 0.00) {
                $invoice->status = InvoiceStatus::REFUNDED;
            }

            $invoice->paid_at = Carbon::now()->format('d-m-Y H:i');
            $invoice->statuses()->create([
                'status' => $invoice->status,
                'description' => 'Status was trigger by populating "amount_paid" field with: ' . $invoice->amount_paid,
            ]);
            $invoice->saveQuietly();
        }

        # CANCELLED
        if ($this->columnInsertCheck($invoice, 'cancelled_at')) {
            $invoice->status = InvoiceStatus::CANCELLED;
            $invoice->statuses()->create([
                'status' => $invoice->status,
                'description' => 'Status was trigger by populating "cancelled_at" field with: ' . $invoice->cancelled_at,
            ]);
            $invoice->saveQuietly();
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        //
    }
}

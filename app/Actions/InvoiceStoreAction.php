<?php

namespace App\Actions;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Workorder;
use Illuminate\Container\Attributes\CurrentUser;

class InvoiceStoreAction
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(Booking|Workorder $resource, Client $client, Vehicle $vehicle, array $attributes): Invoice
    {
        $invoice = new Invoice();

        # workorders totals
        if ($resource::class === Booking::class) {
            foreach ($resource->workorders as $workorder) {
                $invoice->subtotal += (float) $workorder->labour_total_cost;
                $invoice->subtotal += (float) $workorder->part_total_cost;
            }
            $invoice->booking_id = $resource->id;
        } else {
            $invoice->subtotal += $resource->labour_total_cost;
            $invoice->subtotal += $resource->part_total_cost;
            $invoice->workorder_id = $resource->id;
        }

        # operations total minutes
        foreach ($resource->operations as $operation) {
            $invoice->worked_minutes += $operation->times->sum('minutes');
        }

        # invoice totals
        $invoice->tax_amount = $resource->company->tax_value;
        $invoice->total = $invoice->subtotal * (1 + ($invoice->tax_amount / 100));
        $invoice->amount_due = $invoice->total;

        # invoice default fields
        $invoice->amount_paid = 0.00;
        $invoice->notes = $attributes['notes'];
        $invoice->due_date = $attributes['due_date'];
        $invoice->company_id = $resource->company->id;
        $invoice->vehicle_id = $vehicle->id;
        $invoice->client_id = $client->id;

        $invoice->save();

        return $invoice;
    }
}

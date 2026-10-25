<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceLineItem;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Workorder;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Collection;

class InvoiceStoreAction
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(Booking|Workorder $resource, Client $client, Vehicle $vehicle, array $attributes): Invoice
    {
        $invoice = new Invoice();
        $workorders = Collection::make([]);

        # workorders totals
        if ($resource::class === Booking::class) {
            foreach ($resource->workorders as $workorder) {
                $invoice->subtotal += (float) $workorder->labour_total_cost;
                $invoice->subtotal += (float) $workorder->part_total_cost;

                $workorders->push($workorder);
            }
            $invoice->booking_id = $resource->id;
        } else {
            $invoice->subtotal += $resource->labour_total_cost;
            $invoice->subtotal += $resource->part_total_cost;
            $invoice->workorder_id = $resource->id;

            $workorders->push($resource);
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

        // dd($workorders->toArray());

        $invoice->save();

        # INVOICE ITEMS
        foreach ($workorders as $workorder) {
            $item = new InvoiceItem([
                'job_name' => $workorder->title,
                'workorder_number' => $workorder->number,
                'odometer_on_start' => $workorder->odometer_on_start,
                'odometer_on_finish' => $workorder->odometer_on_finish,
                'worked_minutes' => $workorder->operations->map(fn ($op) => $op->times->sum('minutes'))->sum(),
                'labour_rate' => $workorder->labour_rate,
                'total_cost' => (float) $workorder->labour_total_cost + (float) $workorder->part_total_cost,
                'invoice_id' => $invoice->id,
            ]);
            $item->save();

            foreach ($workorder->operations as $operation) {
                // !!! PUT THIS INTO A SERVICE: WorkorderService
                $hour_price = (round($operation->times?->sum('minutes') / 60, 2)) * $operation->workorder->labour_rate;
                $part_price = $operation->part?->selling_price;

                $lineItem = new InvoiceLineItem([
                    'type' => $operation->type,
                    'worked_minutes' => $operation->times->sum('minutes'),
                    'part_id' => $operation->part_id ?? null,
                    'total_cost' => $hour_price + $part_price,
                    'invoice_item_id' => $item->id,
                ]);
                $lineItem->save();
            }
        }

        return $invoice;
    }
}

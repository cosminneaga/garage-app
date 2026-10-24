<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\InvoiceStoreAction;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Vehicle;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use RelatedModelGuard;
    use ResponseMessage;

    public function modelIndex(Request $request, string|int $model_id): View
    {
        self::guard('show', $request, $model_id);

        return view('pages.invoice.index', [
            'invoices' => self::$entity->invoices,
            'resource' => self::$entity,
        ]);
    }

    public function modelCreate(Request $request, string|int $model_id): View
    {
        self::guard('update', $request, $model_id);
        $this->authorize('store', Invoice::class);

        return view('pages.invoice.create.index', [
            'resource' => self::$entity,
            'vehicle' => self::$entity->vehicle,
            'client' => self::$entity->client,
            'company' => self::$entity->company,
        ]);
    }

    public function modelStore(
        StoreInvoiceRequest $request,
        string|int $model_id,
        Client $client,
        Vehicle $vehicle,
        InvoiceStoreAction $action
    ) {
        self::guard('update', $request, $model_id);

        $invoice = $action->handle(self::$entity, $client, $vehicle, $request->safe()->all());

        return redirect()
            ->intended(route('invoices.companies.edit', [$invoice, self::$entity->company]))
            ->with(self::flashMessage(
                'success',
                'Resource created',
                'Invoice ' . $invoice->number . ' created successfully',
            ));
    }

    public function modelEdit(Request $request, Invoice $invoice, Company $company): View
    {
        self::guard('update', $request, $company->id);
        $this->authorize('update', $invoice);

        return view('pages.invoice.edit.index', [
            'invoice' => $invoice,
        ]);
    }

    public function modelUpdate(Request $request, Invoice $invoice, Company $company)
    {
        self::guard('update', $request, $company->id);
        $this->authorize('update', $invoice);

        dd($request->all(), $invoice, $company);
    }
}

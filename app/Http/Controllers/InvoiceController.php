<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\InvoiceStoreAction;
use App\Actions\InvoiceUpdateDiscountAction;
use App\Actions\InvoiceUpdatePaymentValueAction;
use App\Actions\InvoiceUpdateRefundValueAction;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceDiscountRequest;
use App\Http\Requests\UpdateInvoiceDueDateRequest;
use App\Http\Requests\UpdateInvoiceNotesRequest;
use App\Http\Requests\UpdateInvoicePaymentRequest;
use App\Http\Requests\UpdateInvoiceRefundValueRequest;
use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Vehicle;
use App\Notifications\InvoiceSendClientRemainderNotification;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class InvoiceController extends Controller
{
    use RelatedModelGuard;
    use ResponseMessage;

    public function modelIndex(Request $request, string|int $model_id): View
    {
        self::guard('show', $request, $model_id);
        $search = $request->string('search')->value();

        return view('pages.invoice.index', [
            'invoices' => Invoice::search($search)
                ->whereIn('id', self::$entity->invoices->select('id'))
                ->paginate(),
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
        $this->authorize('show', $invoice);

        return view('pages.invoice.edit.index', [
            'invoice' => $invoice,
        ]);
    }

    public function modelPaymentUpdate(
        UpdateInvoicePaymentRequest $request,
        Invoice $invoice,
    ): RedirectResponse {
        App::make(InvoiceUpdatePaymentValueAction::class, [
            'invoice' => $invoice,
        ])->handle(
            $request->validated('method'),
            $request->validated('value')
        );

        return redirect()
            ->back()
            ->with(self::flashMessage(
                'success',
                'Invoice updated',
                'Invoice payment value has been updated'
            ));
    }

    public function modelRefundUpdate(
        UpdateInvoiceRefundValueRequest $request,
        Invoice $invoice,
    ): RedirectResponse {
        App::make(InvoiceUpdateRefundValueAction::class, [
            'invoice' => $invoice,
        ])->handle(
            $request->validated('method'),
            $request->validated('value')
        );

        return redirect()
            ->back()
            ->with(self::flashMessage(
                'success',
                'Invoice updated',
                'Invoice refund value has been updated'
            ));
    }

    public function modelDueDateUpdate(
        UpdateInvoiceDueDateRequest $request,
        Invoice $invoice,
    ): RedirectResponse {
        $invoice->due_date = $request->validated('due_date');
        $invoice->update();

        return redirect()
            ->back()
            ->with(self::flashMessage(
                'success',
                'Invoice updated',
                'Invoice due date has been updated'
            ));
    }

    public function modelNotesUpdate(
        UpdateInvoiceNotesRequest $request,
        Invoice $invoice,
    ): RedirectResponse {
        $invoice->notes = $request->validated('notes');
        $invoice->update();

        return redirect()
            ->back()
            ->with(self::flashMessage(
                'success',
                'Invoice updated',
                'Notes has been updated'
            ));
    }

    public function modelDiscountUpdate(
        UpdateInvoiceDiscountRequest $request,
        Invoice $invoice
    ): RedirectResponse {
        App::make(InvoiceUpdateDiscountAction::class, [
            'invoice' => $invoice,
        ])->handle((float) $request->validated('discount'));

        return redirect()
            ->back()
            ->with(self::flashMessage(
                'success',
                'Invoice updated',
                'New discount has been applied'
            ));
    }

    public function modelSendARemainder(
        Request $request,
        Invoice $invoice,
    ): RedirectResponse {
        $this->authorize('update', $invoice);

        Notification::send($invoice->client, new InvoiceSendClientRemainderNotification($invoice));

        return redirect()
            ->back()
            ->with(self::flashMessage(
                'success',
                'Invoice remainder',
                'Invoice remainder has been sent to the client'
            ));
    }

    public function modelDownload(
        Request $request,
        Invoice $invoice,
    ): never {
        dd($request->all());
    }
}

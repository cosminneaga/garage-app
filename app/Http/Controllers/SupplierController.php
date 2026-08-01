<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\SupplierStoreAction;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Country;
use App\Models\Supplier;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function modelStore(
        StoreSupplierRequest $request,
        string|int $id,
        SupplierStoreAction $action
    ): RedirectResponse {
        self::guard('update', $request, $id);
        $this->authorize('store', Supplier::class);
        $action->handle($request->safe()->all(), self::$entity);

        return back()
            ->with(self::flashMessage(
                'success',
                'Supplier created',
                'Supplier information has been created and attached to respective company',
            ));
    }

    public function modelEdit(
        Request $request,
        Supplier $supplier,
        string|int $id
    ): View {
        self::guard('show', $request, $id);
        $this->authorize('show', $supplier);

        return match (request()->query('tab')) {
            'statistics' => view('pages.supplier.edit.statistics', [
                'supplier' => $supplier,
            ]),
            'contacts' => view('pages.supplier.edit.contacts', [
                'supplier' => $supplier,
            ]),
            'addresses' => view('pages.supplier.edit.addresses', [
                'supplier' => $supplier,
                'countries' => Country::all(),
            ]),
            default => view('pages.supplier.edit.index', [
                'company' => self::$entity,
                'supplier' => $supplier,
            ]),
        };
    }

    public function modelUpdate(
        UpdateSupplierRequest $request,
        Supplier $supplier,
        string|int $id
    ): RedirectResponse {
        self::guard('update', $request, $id);
        $this->authorize('update', $supplier);

        $supplier->update($request->safe()->all());

        return back()
            ->with(self::flashMessage(
                'success',
                'Supplier updated',
                'Supplier information has been successfully updated to respective company',
            ));
    }

    public function modelDestroy(
        Request $request,
        Supplier $supplier,
        string|int $id
    ): RedirectResponse {
        self::guard('update', $request, $id);
        $this->authorize('destroy', $supplier);

        self::$entity->suppliers()->detach($supplier);

        return back()
            ->with(self::flashMessage(
                'info',
                'Supplier removed',
                'Supplier information has been successfully removed from respective company',
            ));
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\SupplierStoreAction;
use App\Enums\Tabs\SupplierTabs;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Traits\RelatedModelGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
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
            SupplierTabs::STATISTICS->value => view('pages.supplier.edit.statistics', [
                'supplier' => $supplier,
            ]),
            SupplierTabs::CONTACT->value => view('pages.supplier.edit.contact', [
                'supplier' => $supplier,
                'contact' => $supplier->contact,
            ]),
            SupplierTabs::ADDRESS->value => view('pages.supplier.edit.address', [
                'supplier' => $supplier,
                'address' => $supplier->address,
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

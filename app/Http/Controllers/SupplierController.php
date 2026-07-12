<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\SupplierStoreAction;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Supplier;
use App\Policies\CompanyPolicy;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    use ResponseMessage;

    public function modelStore(
        StoreSupplierRequest $request,
        Company $company,
        SupplierStoreAction $action
    ): RedirectResponse {
        abort_unless(
            App::make(CompanyPolicy::class)->edit(Auth::user(), $company),
            401
        );
        $this->authorize('create');
        $action->handle($request->safe()->all(), $company);

        return back()
            ->with(self::flashMessage(
                'success',
                'Supplier created',
                'Supplier information has been created and attached to respective company',
            ));
    }

    public function modelEdit(
        Supplier $supplier,
        Company $company
    ): View {
        abort_unless(
            App::make(CompanyPolicy::class)->edit(Auth::user(), $company),
            401
        );
        $this->authorize('edit', $supplier);

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
                'company' => $company,
                'supplier' => $supplier,
            ]),
        };
    }

    public function modelUpdate(
        UpdateSupplierRequest $request,
        Supplier $supplier,
        Company $company
    ): RedirectResponse {
        abort_unless(
            App::make(CompanyPolicy::class)->edit(Auth::user(), $company),
            401
        );
        $this->authorize('edit', $supplier);

        $supplier->update($request->safe()->all());

        return back()
            ->with(self::flashMessage(
                'success',
                'Supplier updated',
                'Supplier information has been successfully updated from respective company',
            ));
    }

    public function modelDestroy(
        Supplier $supplier,
        Company $company
    ): RedirectResponse {
        abort_unless(
            App::make(CompanyPolicy::class)->edit(Auth::user(), $company),
            401
        );
        $this->authorize('delete', $supplier);

        $company->suppliers()->detach($supplier);

        return back()
            ->with(self::flashMessage(
                'info',
                'Supplier removed',
                'Supplier information has been successfully removed from respective company',
            ));
    }

    /**
     * Restore a given item
     */
    public function restore(string|int $id): RedirectResponse
    {
        $supplier = Supplier::onlyTrashed()->find($id);
        $this->authorize('restore', $supplier);
        $supplier->restore();

        return back()
            ->with(self::flashMessage(
                'success',
                'Supplier restored',
                'The supplier has been successfully restored and is now available in your account.',
            ));
    }

    public function edit(Supplier $supplier): View
    {
        $this->authorize('view', $supplier);

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
                'supplier' => $supplier,
            ]),
        };
    }

    public function update(
        UpdateSupplierRequest $request,
        Supplier $supplier
    ): RedirectResponse {
        $this->authorize('edit', $supplier);
        $supplier->update($request->safe()->all());

        return back()
            ->with(self::flashMessage(
                'success',
                'Supplier updated',
                'Supplier information has been successfully updated from respective company',
            ));
    }

    public function destroy(Supplier $supplier)
    {
        $this->authorize('delete', $supplier);
        $supplier->delete();

        return back()
            ->with(self::flashMessage(
                'info',
                'Supplier removed',
                'Supplier has been successfully removed',
            ));
    }
}

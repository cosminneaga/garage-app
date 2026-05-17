<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\SupplierStoreAction;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Company;
use App\Models\Supplier;
use App\Policies\CompanyPolicy;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    use ResponseMessage;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request, Company $company, SupplierStoreAction $action): RedirectResponse
    {
        $this->authorize('create', Supplier::class);
        $guard = app(CompanyPolicy::class)->edit(Auth::user(), $company);
        if (! $guard) {
            abort(401);
        }

        $action->handle($request->safe()->all(), $company);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Supplier created',
                'Supplier information has been created and attached to respective company'
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company, Supplier $supplier): View
    {
        return view('pages.supplier.edit', [
            'company' => $company,
            'supplier' => $supplier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Company $company, Supplier $supplier): RedirectResponse
    {
        $this->authorize('update', $supplier);
        $guard = app(CompanyPolicy::class)->edit(Auth::user(), $company);
        if (! $guard) {
            abort(401);
        }

        $supplier->update($request->safe()->all());

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Supplier updated',
                'Supplier information has been successfully updated from respective company'
            ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Company $company, Supplier $supplier): RedirectResponse
    {
        $this->authorize('delete', $supplier);
        $guard = app(CompanyPolicy::class)->edit(Auth::user(), $company);
        if (! $guard) {
            abort(401);
        }

        $company->suppliers()->detach($supplier);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Supplier removed',
                'Supplier information has been successfully removed from respective company'
            ));
    }

    // ADMIN
    public function all(Request $request): View
    {
        return view('pages.supplier.admin', [
            'suppliers' => Supplier::withTrashed()->paginate(
                perPage: $request->query('limit') ?? 10,
                columns: ['*'],
                pageName: 'suppliers',
                page: null,
                total: null,
            ),
        ]);
    }

    public function destroyUnrelated(Supplier $supplier)
    {
        $supplier->delete();

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Supplier removed',
                'Supplier has been successfully removed'
            ));
    }
}

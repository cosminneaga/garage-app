<?php

namespace App\Http\Controllers;

use App\Actions\ModelAddressStoreAction;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\CompanyPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request, string|int $id, ModelAddressStoreAction $action): RedirectResponse
    {
        $type = array_keys($request->route()->parameters())[0];

        $entity = match ($type) {
            'user' => User::findOrFail($id),
            'company' => Company::findOrFail($id),
            'supplier' => Supplier::findOrFail($id),
        };

        $action->handle($request->safe()->all(), $entity);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Resource created',
                'Address has been created and attached to given resource'
            ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string|int $id, string|int $addressId): View
    {
        $type = array_keys($request->route()->parameters())[0];

        $entity = match ($type) {
            'user' => User::findOrFail($id),
            'company' => Company::findOrFail($id),
            'supplier' => Supplier::findOrFail($id),
        };

        if ($entity instanceof User) {
            app(UserPolicy::class)->view(Auth::user(), $entity);
        } else if ($entity instanceof Company) {
            app(CompanyPolicy::class)->view(Auth::user(), $entity);
        } elseif ($entity instanceof Supplier) {
            app(SupplierPolicy::class)->view(Auth::user(), $entity);
        }

        return view('pages.address.show', [
            'address' => $entity->addresses()->findOrFail($addressId),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string|int $id, string|int $addressId): RedirectResponse
    {
        $type = array_keys($request->route()->parameters())[0];

        $entity = match ($type) {
            'user' => User::findOrFail($id),
            'company' => Company::findOrFail($id),
            'supplier' => Supplier::findOrFail($id),
        };

        if ($entity instanceof User) {
            app(UserPolicy::class)->removeAddress(Auth::user(), $entity);
        } else if ($entity instanceof Company) {
            app(CompanyPolicy::class)->removeAddress(Auth::user(), $entity);
        } elseif ($entity instanceof Supplier) {
            app(SupplierPolicy::class)->removeAddress(Auth::user(), $entity);
        }

        $entity->addresses()->detach($addressId);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Resource removed',
                'Address has been removed from given resource'
            ));
    }
}

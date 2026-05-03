<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ModelAddressStoreAction;
use App\Enums\RelatedModel;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
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
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request, string|int $id, ModelAddressStoreAction $action): RedirectResponse
    {
        $type = array_keys($request->route()->parameters())[0];
        $entity = RelatedModel::from($type)->entity($id);

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
        $entity = RelatedModel::from($type)->entity($id);
        $policy = RelatedModel::from($type)->policy();

        $guard = app($policy)->view(Auth::user(), $entity);
        if (! $guard) {
            abort(401);
        }

        return view('pages.address.show', [
            'address' => $entity->addresses()->findOrFail($addressId),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string|int $id, string|int $addressId): RedirectResponse
    {
        $type = array_keys($request->route()->parameters())[0];
        $entity = RelatedModel::from($type)->entity($id);
        $policy = RelatedModel::from($type)->policy();

        $guard = app($policy)->removeAddress(Auth::user(), $entity);
        if (! $guard) {
            abort(401);
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

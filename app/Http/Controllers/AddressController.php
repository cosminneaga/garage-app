<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ModelAddressStoreAction;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Country;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    /**
     * Store a newly created resource in storage.
     */
    public function modelStore(
        StoreAddressRequest $request,
        string|int $id,
        ModelAddressStoreAction $action
    ): RedirectResponse {
        self::guard($request, $id)->update();
        $action->handle($request->safe()->all(), self::$entity);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource created',
                'Address has been created and attached to given resource',
            ));
    }

    /**
     * Display the specified resource.
     */
    public function modelEdit(
        Request $request,
        string|int $addressId,
        string|int $id
    ): View {
        self::guard($request, $id)->show();
        $resource = self::$entity->addresses()->findOrFail($addressId);

        return view('pages.address.edit', [
            'countries' => Country::all(),
            'resource' => $resource,
        ]);
    }

    /**
     * Update the specified resource
     */
    public function modelUpdate(
        Request $request,
        string|int $addressId,
        string|int $id
    ) {
        self::guard($request, $id)->update();
        $resource = self::$entity->addresses()->findOrFail($addressId);
        $resource->update([...$request->except(['_token', '_method'])]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Address updated successfully'
            ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function modelDestroy(
        Request $request,
        string|int $addressId,
        string|int $id
    ): RedirectResponse {
        self::guard($request, $id)->update();
        self::$entity->addresses()->detach($addressId);

        return back()
            ->with(self::flashMessage(
                'info',
                'Resource removed',
                'Address has been removed from given resource',
            ));
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ModelAddressStoreAction;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Models\Country;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function modelStore(
        StoreAddressRequest $request,
        string|int $id,
        ModelAddressStoreAction $action
    ): RedirectResponse {
        self::guard('update', $request, $id);
        $this->authorize('store', Address::class);

        try {
            $action->handle($request->safe()->all(), self::$entity);
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with(self::flashMessage(
                    'error',
                    'Resource not created',
                    $e->getMessage(),
                ));
        }

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource created',
                'Address has been created and attached to given resource',
            ));
    }

    public function modelEdit(
        Request $request,
        Address $address,
        string|int $model_id
    ): View {
        self::guard('show', $request, $model_id);
        $resource = self::$entity->addresses()->findOrFail($address->id);
        $this->authorize('show', $resource);

        return view('pages.address.edit', [
            'countries' => Country::all(),
            'resource' => $resource,
        ]);
    }

    public function modelUpdate(
        Request $request,
        Address $address,
        string|int $model_id
    ) {
        self::guard('update', $request, $model_id);
        $resource = self::$entity->addresses()->findOrFail($address);
        $this->authorize('update', $resource);
        $resource->update([...$request->except(['_token', '_method'])]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Address updated successfully'
            ));
    }

    public function modelDestroy(
        Request $request,
        Address $address,
        string|int $model_id
    ): RedirectResponse {
        self::guard('update', $request, $model_id);
        self::$entity->addresses()->detach($address->id);

        return back()
            ->with(self::flashMessage(
                'info',
                'Resource removed',
                'Address has been removed from given resource',
            ));
    }
}

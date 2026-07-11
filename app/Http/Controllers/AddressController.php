<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ModelAddressStoreAction;
use App\Enums\Related\RelatedAddressContact;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Country;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddressController extends Controller
{
    use ResponseMessage;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request, string|int $id, ModelAddressStoreAction $action): RedirectResponse
    {
        $type = Collection::make($request->route()->parameters())->keys()->last();
        $relatedModel = RelatedAddressContact::from($type);
        $entity = $relatedModel->entity($id);
        abort_unless(
            App::make($relatedModel->policy())->edit(Auth::user(), $entity),
            401
        );

        $action->handle($request->safe()->all(), $entity);

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
    public function edit(Request $request, string|int $addressId, string|int $id): View
    {
        $type = Collection::make($request->route()->parameters())->keys()->last();
        $relatedModel = RelatedAddressContact::from($type);
        $entity = $relatedModel->entity($id);
        abort_unless(
            App::make($relatedModel->policy())->view(Auth::user(), $entity),
            401
        );

        $resource = $entity->addresses()->findOrFail($addressId);
        Session::flashInput([
            'street_number' => $resource->street_number,
            'street' => $resource->street,
            'postcode' => $resource->postcode,
            'building' => $resource->building,
            'floor' => $resource->floor,
            'unit' => $resource->unit,
            'country_id' => $resource->country_id,
            'coordinates' => [
                'latitude' => $resource->coordinates?->latitude,
                'longitude' => $resource->coordinates?->longitude,
            ],
        ]);
        return view('pages.address.edit', [
            'countries' => Country::all(),
        ]);
    }

    /**
     * Update the specified resource
     */
    public function update(Request $request, string|int $addressId, string|int $id)
    {
        $type = Collection::make($request->route()->parameters())->keys()->last();
        $relatedModel = RelatedAddressContact::from($type);
        $entity = $relatedModel->entity($id);
        abort_unless(
            App::make($relatedModel->policy())->view(Auth::user(), $entity),
            401
        );

        $resource = $entity->addresses()->findOrFail($addressId);
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
    public function destroy(Request $request, string|int $addressId, string|int $id): RedirectResponse
    {
        $type = Collection::make($request->route()->parameters())->keys()->last();
        $relatedModel = RelatedAddressContact::from($type);
        $entity = $relatedModel->entity($id);
        abort_unless(
            App::make($relatedModel->policy())->edit(Auth::user(), $entity),
            401
        );

        $entity->addresses()->detach($addressId);

        return back()
            ->with(self::flashMessage(
                'info',
                'Resource removed',
                'Address has been removed from given resource',
            ));
    }
}

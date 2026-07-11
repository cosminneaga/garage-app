<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ModelContactStoreAction;
use App\Enums\Related\RelatedAddressContact;
use App\Http\Requests\StoreContactRequest;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    use ResponseMessage;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request, string|int $id, ModelContactStoreAction $action): RedirectResponse
    {
        $type = Collection::make($request->route()->parameters())->keys()->last();
        $entity = RelatedAddressContact::from($type)->entity($id);

        $action->handle($request->safe()->all(), $entity);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Resource created',
                'Contact has been created and attached to given resource',
            ));
    }

    /**
     * Display the specified resource.
     */
    public function edit(Request $request, string|int $contactId, string|int $id): View
    {
        $type = Collection::make($request->route()->parameters())->keys()->last();
        $relatedModel = RelatedAddressContact::from($type);
        $entity = $relatedModel->entity($id);
        abort_unless(
            App::make($relatedModel->policy())->edit(Auth::user(), $entity),
            401
        );

        $resource = $entity->contacts()->findOrFail($contactId);
        Session::flashInput([
            'email' => $resource->email,
            'mobile' => $resource->mobile,
            'landline' => $resource->landline,
            'url' => $resource->url,
            'info' => $resource->info,
        ]);

        return view('pages.contact.edit');
    }

    /**
     * Update the specified resource
     */
    public function update(Request $request, string|int $contactId, string|int $id): RedirectResponse
    {
        $type = Collection::make($request->route()->parameters())->keys()->last();
        $relatedModel = RelatedAddressContact::from($type);
        $entity = $relatedModel->entity($id);
        abort_unless(
            App::make($relatedModel->policy())->edit(Auth::user(), $entity),
            401
        );

        $resource = $entity->contacts()->findOrFail($contactId);
        $resource->update([...$request->except(['_token', '_method'])]);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Resource updated',
                'Contact updated successfully'
            ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string|int $contactId, string|int $id): RedirectResponse
    {
        $type = Collection::make($request->route()->parameters())->keys()->last();
        $relatedModel = RelatedAddressContact::from($type);
        $entity = $relatedModel->entity($id);
        abort_unless(
            App::make($relatedModel->policy())->edit(Auth::user(), $entity),
            401
        );

        $entity->contacts()->detach($contactId);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Resource removed',
                'Contact has been removed from given resource',
            ));
    }
}

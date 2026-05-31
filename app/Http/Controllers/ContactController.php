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
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    use ResponseMessage;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request, string|int $id, ModelContactStoreAction $action): RedirectResponse
    {
        $type = array_keys($request->route()->parameters())[0];
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
    public function edit(Request $request, string|int $id, string|int $contactId): View
    {
        $type = array_keys($request->route()->parameters())[0];
        $entity = RelatedAddressContact::from($type)->entity($id);
        $policy = RelatedAddressContact::from($type)->policy();

        $guard = app($policy)->view(Auth::user(), $entity);
        if (! $guard) {
            abort(401);
        }

        return view('pages.contact.edit', [
            'contact' => $entity->contacts()->findOrFail($contactId),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string|int $id, string|int $contactId): RedirectResponse
    {
        $type = array_keys($request->route()->parameters())[0];
        $entity = RelatedAddressContact::from($type)->entity($id);
        $policy = RelatedAddressContact::from($type)->policy();

        $guard = app($policy)->edit(Auth::user(), $entity);
        if (! $guard) {
            abort(401);
        }

        $entity->contacts()->detach($contactId);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Resource removed',
                'Contact has been removed from given resource',
            ));
    }
}

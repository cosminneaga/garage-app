<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ModelContactStoreAction;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function modelStore(
        StoreContactRequest $request,
        string|int $id,
        ModelContactStoreAction $action
    ): RedirectResponse {
        self::guard('update', $request, $id);
        $this->authorize('store', Contact::class);

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
                'Contact has been created and attached to given resource',
            ));
    }

    public function modelEdit(
        Request $request,
        Contact $contact,
        string|int $model_id
    ): View {
        self::guard('show', $request, $model_id);
        $resource = self::$entity->contacts()->findOrFail($contact->id);
        $this->authorize('show', $resource);

        return view('pages.contact.edit', [
            'resource' => $resource,
        ]);
    }

    public function modelUpdate(
        Request $request,
        Contact $contact,
        string|int $model_id
    ): RedirectResponse {
        self::guard('update', $request, $model_id);
        $resource = self::$entity->contacts()->findOrFail($contact->id);
        $this->authorize('update', $resource);
        $resource->update([...$request->except(['_token', '_method'])]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Contact updated successfully'
            ));
    }


    public function modelDestroy(
        Request $request,
        Contact $contact,
        string|int $model_id
    ): RedirectResponse {
        self::guard('update', $request, $model_id);
        $this->authorize('destroy', $contact);
        self::$entity->contacts()->detach($contact);

        return back()
            ->with(self::flashMessage(
                'info',
                'Resource removed',
                'Contact has been removed from given resource',
            ));
    }
}

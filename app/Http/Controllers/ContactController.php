<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ModelContactStoreAction;
use App\Http\Requests\StoreContactRequest;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        string|int $contactId,
        string|int $id
    ): View {
        self::guard('show', $request, $id);
        $resource = self::$entity->contacts()->findOrFail($contactId);

        Session::flashInput([
            'email' => $resource->email,
            'mobile' => $resource->mobile,
            'landline' => $resource->landline,
            'url' => $resource->url,
            'info' => $resource->info,
        ]);

        return view('pages.contact.edit');
    }

    public function modelUpdate(
        Request $request,
        string|int $contactId,
        string|int $id
    ): RedirectResponse {
        self::guard('update', $request, $id);
        $resource = self::$entity->contacts()->findOrFail($contactId);
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
        string|int $contactId,
        string|int $id
    ): RedirectResponse {
        self::guard('update', $request, $id)->update();
        self::$entity->contacts()->detach($contactId);

        return back()
            ->with(self::flashMessage(
                'info',
                'Resource removed',
                'Contact has been removed from given resource',
            ));
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ClientStoreAction;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Company;
use App\Models\Country;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use RelatedModelGuard;
    use ResponseMessage;

    public function modelStore(
        StoreClientRequest $request,
        Company $company,
        ClientStoreAction $action
    ): RedirectResponse {
        self::guard('update', $request, $company->id);
        $this->authorize('store', Client::class);

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');

        try {
            $action->handle($attributes, self::$entity);
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
                'Client has been created and attached to given resource',
            ));
    }

    public function modelEdit(
        Request $request,
        Client $client,
        Company $company
    ): View {
        self::guard('show', $request, $company->id);
        $resource = self::$entity->clients()->findOrFail($client->id);
        $this->authorize('show', $resource);

        return match (request()->query('tab')) {
            'statistics' => view('pages.client.edit.statistics', [
                'resource' => $client,
            ]),
            'contacts' => view('pages.client.edit.contacts', [
                'resource' => $client,
            ]),
            'addresses' => view('pages.client.edit.addresses', [
                'resource' => $client,
                'countries' => Country::all(),
            ]),
            default => view('pages.client.edit.index', [
                'resource' => $client,
                'parent' => $company,
            ])
        };
    }

    public function modelUpdate(
        UpdateClientRequest $request,
        Client $client,
        Company $company
    ): RedirectResponse {
        self::guard('update', $request, $company->id);
        $this->authorize('update', $client);

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $client->update([...$attributes]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Client has been successfully updated'
            ));
    }

    public function modelDestroy(
        Request $request,
        Client $client,
        Company $company
    ): RedirectResponse {
        self::guard('update', $request, $company->id);
        $this->authorize('destroy', $client);
        $company->clients()->detach($client);

        return back()
            ->with(self::flashMessage(
                'info',
                'Resource removed',
                'Client has been removed from given resource',
            ));
    }
}

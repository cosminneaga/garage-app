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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    use RelatedModelGuard;
    use ResponseMessage;

    public function index(Request $request): View
    {
        $client = Auth::guard('client')->user();

        return view('pages.client.portal.home', [
            'bookings' => $client->bookings,
            'workorders' => $client->workorders,
            'contacts' => $client->contacts,
            'addresses' => $client->addresses,
            'countries' => Country::all(),
        ]);
    }

    public function modelSearch(
        Request $request,
        Company $company
    ): JsonResponse {
        self::guard('show', $request, $company->id);
        $this->authorize('showAll', Client::class);
        $search = $request->string('search')->value();
        $existingClients = Client::whereHas('companies', fn ($query) => $query->whereIn('companies.id', [$company->id]))->pluck('clients.id');
        $clients = Client::search($search)->whereIn('id', $existingClients)->get();

        if (!count($clients)) {
            $clients = Client::search('')->whereIn('id', $existingClients)->get();
        }

        return response()->json($clients);
    }

    public function modelIndex(Request $request, Company $company): JsonResponse
    {
        $search = $request->string('search')->value();
        $existingClients = Client::whereHas('companies', fn ($query) => $query->whereIn('companies.id', [$company->id]))->pluck('clients.id');
        $clients = Client::search($search)->whereIn('id', $existingClients)->paginate(env('PAGINATE_DEFAULT_PER_PAGE', 10), 'company_clients');

        return response()->json($clients);
    }

    public function modelStore(
        StoreClientRequest $request,
        Company $company,
        ClientStoreAction $action
    ): RedirectResponse {
        self::guard('update', $request, $company->id);
        $this->authorize('store', Client::class);
        $attributes = $request->safe()->all();

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

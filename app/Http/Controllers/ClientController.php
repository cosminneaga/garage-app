<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Columns\ClientColumns;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Company;
use App\Traits\RelatedModelGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    use RelatedModelGuard;

    public function index(Request $request): View
    {
        $this->authorize('showAll', Client::class);
        $search = $request->string('search')->value();

        $companyIds = Auth::user()->companies()->pluck('companies.id');
        $clients = Client::search($search)
            ->whereIn(
                'id',
                Client::query()
                    ->whereHas('companies', fn($query) => $query->whereIn('companies.id', $companyIds))
                    ->select('id')
            )
            ->query(fn($query) => $query->select([...ClientColumns::values()]))
            ->get();

        return view('pages.client.index', [
            'clients' => $clients,
        ]);
    }

    public function edit(Request $request, Client $client): View {
        $this->authorize('show', $client);

        return match(request()->query('tab')) {
            'statistics' => view('pages.client.edit.statistics'),
            default => view('pages.client.edit.index', [
                'resource' => $client,
            ])
        };
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        dd($request->safe()->all(), $client);
    }

    public function destroy(Client $client)
    {
        dd($client);
    }

    public function modelStore(StoreClientRequest $request, Company $company): never
    {
        self::guard('update', $request, $company->id);
        $this->authorize('store', Client::class);

        dd($request->safe()->all());
    }
}

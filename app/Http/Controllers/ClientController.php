<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use App\Models\Company;
use App\Traits\RelatedModelGuard;

class ClientController extends Controller
{
    use RelatedModelGuard;

    public function modelIndex()
    {
    }

    public function modelCreate()
    {
    }

    public function modelStore(StoreClientRequest $request, Company $company): never
    {
        self::guard('update', $request, $company->id);
        $this->authorize('store', Client::class);

        dd($request->safe()->all());
    }
}

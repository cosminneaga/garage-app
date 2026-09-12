<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Models\Company;
use App\Models\Vehicle;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;

class VehicleController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function modelStore(StoreVehicleRequest $request, Company $company): void
    {
        self::guard('update', $request, $company->id);
        $this->authorize('store', Vehicle::class);

        dd($request->safe()->all());
    }

    public function destroy()
    {
    }
    public function restore()
    {
    }
}

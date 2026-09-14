<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Models\Company;
use App\Models\Vehicle;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Http\RedirectResponse;

class VehicleController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function modelStore(StoreVehicleRequest $request, Company $company): RedirectResponse
    {
        self::guard('update', $request, $company->id);
        $this->authorize('store', Vehicle::class);

        $vehicle = Vehicle::create($request->safe()->all());
        $company->vehicles()->attach($vehicle);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource created',
                'Vehicle has been stored'
            ));
    }

    public function destroy()
    {
    }
    public function restore()
    {
    }
}

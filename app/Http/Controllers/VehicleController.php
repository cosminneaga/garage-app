<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Models\Company;
use App\Models\Vehicle;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function modelSearch(
        Request $request,
        Company $company
    ): JsonResponse {
        self::guard('show', $request, $company->id);
        $this->authorize('showAll', Vehicle::class);
        $search = $request->string('search')->value();
        $existingVehicle = Vehicle::whereHas('companies', fn ($query) => $query->whereIn('companies.id', [$company->id]))->pluck('vehicles.id');
        $vehicles = Vehicle::search($search)->whereIn('id', $existingVehicle)->get();

        if (!count($vehicles)) {
            $vehicles = Vehicle::search('')->whereIn('id', $existingVehicle)->get();
        }

        return response()->json($vehicles);
    }

    public function modelIndex(Request $request, Company $company): JsonResponse
    {
        $search = $request->string('search')->value();
        $existingVehicles = Vehicle::whereHas('companies', fn ($query) => $query->whereIn('companies.id', [$company->id]))->pluck('vehicles.id');
        $chiecles = Vehicle::search($search)->whereIn('id', $existingVehicles)->paginate(env('PAGINATE_DEFAULT_PER_PAGE', 10), 'company_vehicles');

        return response()->json($chiecles);
    }

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

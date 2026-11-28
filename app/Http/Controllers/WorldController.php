<?php

namespace App\Http\Controllers;

use App\Models\World\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WorldController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->string('search')->value();
        $countries = Country::with([
            'states' => fn ($query) => $query->select('id', 'country_id', 'name', 'country_code'),
            'states.cities' => fn ($query) => $query->select('id', 'state_id', 'country_id', 'name', 'country_code'),
        ])
            ->where('name', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'region']);

        return response()->json($countries);
    }

    public function country(Country $country): JsonResponse
    {
        $resource = Cache::rememberForever('countries.' . $country->id, fn () => Country::with(['states', 'states.cities'])->find($country->id));
        return response()->json($resource);
    }
}

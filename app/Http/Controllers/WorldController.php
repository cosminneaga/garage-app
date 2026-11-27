<?php

namespace App\Http\Controllers;

use App\Models\World\City;
use App\Models\World\Country;
use App\Models\World\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function countries(Request $request): JsonResponse
    {
        $search = $request->string('search')->value();
        $data = Country::where('name', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'region']);

        return response()->json($data);
    }

    public function states(Request $request, Country $country): JsonResponse
    {
        dd($country->getAttributes());
        $search = $request->string('search')->value();
        $data = State::where('country_id', $country->id)
            ->where('name', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'country_code']);

        return response()->json($data);
    }

    public function cities(Request $request, State $state): JsonResponse
    {
        $search = $request->string('search')->value();
        $data = City::where('state_id', $state->id)
            ->where('name', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'region']);

        return response()->json($data);
    }
}

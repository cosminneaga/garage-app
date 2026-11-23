<?php

namespace App\Http\Controllers;

use App\Models\World\Country;
use Illuminate\Http\Request;

class WorldController extends Controller
{
    public function countries(Request $request)
    {
        return response()->json(Country::all());
    }

    public function query(Request $request)
    {
        $request_country = $request->query('country');
        $request_state = $request->query('state');
        $request_city = $request->query('city');

        $country = Country::findOrFail($request_country);

        return response()->json([
            'country' => $country,
            'states' => $country->states,
            'cities' => $country->cities,
        ]);
    }
}

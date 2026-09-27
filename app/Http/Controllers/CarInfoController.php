<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CarData;
use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spiral\RoadRunner\Http\Request as HttpRequest;

class CarInfoController extends Controller
{
    public function makes(Request $request)
    {
        return response()->json(CarMake::all());
    }

    public function models(Request $request, CarMake $make)
    {
        return response()->json($make->models);
    }

    public function data(Request $request, CarMake $make, CarModel $model)
    {
        $data = CarData::where('make_id', $make->id)
            ->where('model_id', $model->id)
            ->get();

        return response()->json($data);
    }

    public function makeSearch(Request $request): JsonResponse {
        $search = $request->string('search')->value();
        $makes = CarMake::search($search)
            ->get()
            ->unique('name')
            ->map(fn ($model) => $model->setVisible(['id', 'name']))
            ->values();

        return response()->json($makes->toArray());
    }
}

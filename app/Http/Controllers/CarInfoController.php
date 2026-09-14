<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CarData;
use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Http\Request;

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
}

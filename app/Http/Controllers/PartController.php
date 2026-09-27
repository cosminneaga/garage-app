<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Part;
use App\Traits\RelatedModelGuard;
use Illuminate\Http\Request;

class PartController extends Controller
{
    use RelatedModelGuard;

    public function modelSearch(
        Request $request
    ) {
        $search = $request->string('search')->value();
        $makes = Part::search($search)
            ->get()
            ->unique('name')
            // ->map(fn($model) => $model->setVisible(['id', 'name']))
            ->values();

        return response()->json($makes->toArray());
    }

    public function modelStore()
    {
    }

    public function modelEdit()
    {
    }

    public function modelUpdate()
    {
    }

    public function modelDestroy()
    {
    }
}

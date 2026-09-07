<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WorkorderOperation;
use App\Models\WorkorderOperationLabourTime;
use App\Traits\RelatedModelGuard;
use Illuminate\Http\Request;

class WorkorderOperationLabourTimeController extends Controller
{
    use RelatedModelGuard;

    public function modelStore()
    {
    }

    public function modelEdit(
        Request $request,
        WorkorderOperationLabourTime $time,
        WorkorderOperation $operation
    ): never {
        self::guard('show', $request, $operation->id);
        dd($time);
    }

    public function modelUpdate()
    {
    }

    public function modelDestroy()
    {
    }
}

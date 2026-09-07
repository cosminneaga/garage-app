<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Workorder;
use App\Models\WorkorderOperation;
use App\Traits\RelatedModelGuard;
use Illuminate\Http\Request;

class WorkorderOperationController extends Controller
{
    use RelatedModelGuard;

    public function modelStore()
    {
    }

    public function modelEdit(
        Request $request,
        WorkorderOperation $operation,
        Workorder $workorder
    ): never {
        self::guard('show', $request, $workorder->id);
        dd($operation);
    }

    public function modelUpdate()
    {
    }

    public function modelDestroy()
    {
    }
}

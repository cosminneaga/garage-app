<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\RelatedModelGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyScheduleController extends Controller
{
    use RelatedModelGuard;

    public function modelIndex(Request $request, Company $company): JsonResponse
    {
        self::guard('show', $request, $company->id);

        return response()->json($company->schedules);
    }
}

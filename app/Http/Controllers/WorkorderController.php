<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Workorder;
use App\Traits\RelatedModelGuard;
use Illuminate\Http\Request;

class WorkorderController extends Controller
{
    use RelatedModelGuard;

    public function modelStore()
    {
    }

    public function modelEdit(
        Request $request,
        Workorder $workorder,
        Booking $booking
    ): never {
        self::guard('show', $request, $booking->id);
        dd($workorder);
    }

    public function modelUpdate()
    {
    }

    public function modelDestroy()
    {
    }
}

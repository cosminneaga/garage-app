<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WorkorderOperation;
use App\Models\WorkorderOperationLabourTime;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WorkorderOperationLabourTimeController extends Controller
{
    use RelatedModelGuard;
    use ResponseMessage;

    # start a time window
    public function modelStore(
        Request $request,
        WorkorderOperation $operation
    ): RedirectResponse
    {
        self::guard('update', $request, $operation->id);
        $this->authorize('store', WorkorderOperationLabourTime::class);
        $operation->times()->create([
            'start' => Carbon::now()->format('d-m-Y H:i')
        ]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource update',
                'Time has started'
            ));
    }

    # end a time window
    public function modelUpdate(
        Request $request,
        WorkorderOperationLabourTime $time,
        WorkorderOperation $operation,
    ): RedirectResponse
    {
        self::guard('update', $request, $operation->id);
        $this->authorize('update', $time);
        $time->update([
            'end' => Carbon::now()->format('d-m-Y H:i')
        ]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource update',
                'Time has ended'
            ));
    }
}

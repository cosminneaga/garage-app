<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkorderOperationRequest;
use App\Models\Part;
use App\Models\Workorder;
use App\Models\WorkorderOperation;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkorderOperationController extends Controller
{
    use RelatedModelGuard;
    use ResponseMessage;

    public function modelCreate(Request $request, Workorder $workorder): View
    {
        self::guard('update', $request, $workorder->id);
        $this->authorize('store', WorkorderOperation::class);

        return view('pages.workorder_operation.create', [
            'workorder' => $workorder,
            'available_parts' => Part::whereIn('supplier_id', $workorder->booking->company->suppliers->select('id'))->get(),
        ]);
    }

    public function modelStore(StoreWorkorderOperationRequest $request, Workorder $workorder): RedirectResponse
    {
        self::guard('update', $request, $workorder->id);
        $this->authorize('store', WorkorderOperation::class);

        $workorder->operations()->create([...$request->safe()->all(), 'performed_by' => Auth::user()->id]);

        return redirect()->intended(route('workorders.bookings.edit', [$workorder, $workorder->booking]))
            ->with(self::flashMessage(
                'success',
                'Resource created',
                'Workorder Operation has been successfully created and attached to current Workorder'
            ));
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

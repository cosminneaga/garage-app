<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkorderOperationRequest;
use App\Http\Requests\UpdateWorkorderOperationRequest;
use App\Models\Workorder;
use App\Models\WorkorderOperation;
use App\Services\PartService;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WorkorderOperationController extends Controller
{
    use RelatedModelGuard;
    use ResponseMessage;

    public function __construct(
        protected PartService $partService
    ) {
        //
    }

    public function modelCreate(Request $request, Workorder $workorder): View
    {
        self::guard('update', $request, $workorder->id);
        $this->authorize('store', WorkorderOperation::class);

        $parent = $workorder->company;
        if ($workorder->booking) {
            $parent = $workorder->booking;
        }

        return view('pages.workorder_operation.create', [
            'workorder' => $workorder,
            'available_parts' => $this->partService->getAllByParentModel($parent),
            'technicians' => $parent->availableTechnicians()->get(),
        ]);
    }

    public function modelStore(StoreWorkorderOperationRequest $request, Workorder $workorder): RedirectResponse
    {
        self::guard('update', $request, $workorder->id);
        $this->authorize('store', WorkorderOperation::class);
        $operation = WorkorderOperation::forceCreate([
            ...$request->safe()->all(),
            'workorder_id' => $workorder->id,
        ]);

        return redirect()->intended(route('operations.workorders.edit', [$operation, $workorder]))
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
    ): View {
        self::guard('show', $request, $workorder->id);
        $this->authorize('show', $operation);

        $parent = $workorder->company;
        if ($workorder->booking) {
            $parent = $workorder->booking;
        }

        return view('pages.workorder_operation.edit.index', [
            'workorder' => $workorder,
            'workorder_parent' => $parent,
            'operation' => $operation,
            'times' => $operation->times,
            'available_parts' => $this->partService->getAllByParentModel($parent),
            'technicians' => $parent->availableTechnicians()->get(),
        ]);
    }

    public function modelUpdate(
        UpdateWorkorderOperationRequest $request,
        WorkorderOperation $operation,
        Workorder $workorder
    ): RedirectResponse {
        self::guard('update', $request, $workorder->id);
        $this->authorize('update', $operation);
        $operation->update($request->safe()->all());

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Workorder Operation has been successfully updated'
            ));
    }
}

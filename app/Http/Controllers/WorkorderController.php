<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkorderRequest;
use App\Http\Requests\UpdateWorkorderRequest;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Workorder;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkorderController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function index(): View
    {
        return view('pages.workorder.index', [
            'workorders' => Auth::user()->woAssigned,
            'parent' => null,
        ]);
    }

    public function modelIndex(
        Request $request,
        string|int $model_id
    ): View
    {
        self::guard('show', $request, $model_id);
        $this->authorize('showAll', Workorder::class);

        return view('pages.workorder.index', [
            'workorders' => self::$entity->workorders,
            'parent' => self::$entity,
        ]);
    }

    public function modelCreate(
        Request $request,
        string|int $model_id
    ): View {
        self::guard('update', $request, $model_id);
        $this->authorize('store', Workorder::class);

        return view('pages.workorder.create.' . self::$relatedName, [
            'parent' => self::$entity,
            'technicians' => self::$entity->availableTechnicians()->get(),
        ]);
    }

    public function modelStore(
        StoreWorkorderRequest $request,
        string|int $model_id
    ): RedirectResponse {
        self::guard('update', $request, $model_id);

        $fields = match (self::$entity::class) {
            Booking::class => [
                    'booking_id' => self::$entity->id,
                    'company_id' => self::$entity->company->id,
                ],
            Company::class => [
                    'company_id' => self::$entity->id,
                ],
        };

        $workorder = Workorder::create([
            ...$request->safe()->all(),
            ...$fields,
        ]);

        $route = match (self::$entity::class) {
            Booking::class => route('bookings.companies.edit', [self::$entity, self::$entity->company]),
            Company::class => route('workorders.companies.edit', [$workorder, self::$entity]),
        };

        return redirect()->intended($route)
            ->with(self::flashMessage(
                'success',
                'Resource created',
                'Workorder created sucessfully'
            ));
    }

    public function modelEdit(
        Request $request,
        Workorder $workorder,
        string|int $model_id
    ): View {
        self::guard('show', $request, $model_id);
        $this->authorize('update', $workorder);

        return view('pages.workorder.edit.' . self::$relatedName, [
            'workorder' => $workorder,
            'operations' => $workorder->operations,
            'parent' => self::$entity,
            'technicians' => self::$entity->availableTechnicians()->get(),
        ]);
    }

    public function modelUpdate(
        UpdateWorkorderRequest $request,
        Workorder $workorder,
        string|int $model_id
    ): RedirectResponse {
        self::guard('show', $request, $model_id);
        $this->authorize('update', $workorder);

        $workorder->update([...$request->safe()->all()]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Workorder updated successfully'
            ));
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkorderRequest;
use App\Http\Requests\UpdateWorkorderRequest;
use App\Models\Booking;
use App\Models\Workorder;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WorkorderController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function modelCreate(
        Request $request,
        Booking $booking
    ): View {
        self::guard('update', $request, $booking->id);
        $this->authorize('store', Workorder::class);

        return view('pages.workorder.create', [
            'booking' => $booking,
            'technicians' => $booking->availableTechnicians()->get(),
        ]);
    }

    public function modelStore(
        StoreWorkorderRequest $request,
        Booking $booking
    ): RedirectResponse {
        self::guard('update', $request, $booking->id);
        Workorder::create([
            ...$request->safe()->all(),
            'booking_id' => $booking->id,
        ]);

        return redirect()->intended(route('bookings.companies.edit', [$booking, $booking->company]))
            ->with(self::flashMessage(
                'success',
                'Resource created',
                'Workorder created sucessfully'
            ));
    }

    public function modelEdit(
        Request $request,
        Workorder $workorder,
        Booking $booking
    ): View {
        self::guard('show', $request, $booking->id);
        $this->authorize('update', $workorder);

        return view('pages.workorder.edit.index', [
            'workorder' => $workorder,
            'operations' => $workorder->operations,
            'booking' => $booking,
            'technicians' => $booking->availableTechnicians()->get(),
        ]);
    }

    public function modelUpdate(
        UpdateWorkorderRequest $request,
        Workorder $workorder,
        Booking $booking
    ): RedirectResponse {
        self::guard('update', $request, $booking->id);
        $this->authorize('update', $workorder);

        $workorder->update([...$request->safe()->all()]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Workorder updated successfully'
            ));
    }

    public function modelDestroy()
    {
    }
}

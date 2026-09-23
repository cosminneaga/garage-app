<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreWorkorderRequest;
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

    public function modelCreate(Request $request, Booking $booking): View
    {
        self::guard('update', $request, $booking->id);
        $this->authorize('store', Workorder::class);

        return view('pages.workorder.create', [
            'booking' => self::$entity,
            'technicians' => self::$entity->company->users()->role([UserRole::MANAGER, UserRole::USER])->get()
        ]);
    }

    public function modelStore(StoreWorkorderRequest $request, Booking $booking): RedirectResponse
    {
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
    ): never {
        self::guard('show', $request, $booking->id);
        dd($workorder);
    }

    public function modelUpdate(Request $request, Workorder $workorder, Booking $booking)
    {
        dd($workorder->toArray(), $booking->toArray());
    }

    public function modelDestroy()
    {
    }
}

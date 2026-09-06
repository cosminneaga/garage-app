<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Traits\RelatedModelGuard;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use RelatedModelGuard;

    public function modelIndex(Request $request, string|int $parent_id): View
    {
        self::guard('show', $request, $parent_id);
        $search = $request->string('search')->value();

        return view('pages.booking.index', [
            'bookings' => self::$entity->bookings,
        ]);
    }

    public function modelStore(
        StoreBookingRequest $request,
        string|int $parent_id
    ): RedirectResponse {
        self::guard('update', $request, $parent_id);

        try {
            Booking::create();
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with(self::flashMessage(
                    'error',
                    'Resource not created',
                    $e->getMessage(),
                ));
        }

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource created',
                'Booking has been created and attached to given resource',
            ));
    }

    public function modelEdit(
        Request $request,
        Booking $booking,
        string|int $parent_id
    ): View {
        self::guard('show', $request, $parent_id);
        $resource = self::$entity->bookings()->findOrFail($booking->id);
        $this->authorize('show', $resource);

        return view('pages.booking.edit.index', [
            'booking' => $resource
        ]);
    }

    public function modelUpdate(
        UpdateBookingRequest $request,
        Booking $booking,
        string|int $parent_id
    ): RedirectResponse {
        self::guard('update', $request, $parent_id);
        $resource = self::$entity->addresses()->findOrFail($booking->id);
        $this->authorize('update', $resource);
        $resource->update([...$request->except(['_token', '_method'])]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Booking updated successfully'
            ));
    }

    public function modelDestroy(
        Request $request,
        Booking $booking,
        string|int $parent_id
    ): RedirectResponse {
        self::guard('update', $request, $parent_id);
        self::$entity->addresses()->detach($booking->id);

        return back()
            ->with(self::flashMessage(
                'info',
                'Resource removed',
                'Booking has been removed from given resource',
            ));
    }

    public function clientData(): void
    {
        # grab and validate client_url_token
        # grab client notes
        # grab client files
    }
}

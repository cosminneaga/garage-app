<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TableMap\BookingTableMap;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Company;
use App\Traits\RelatedModelGuard;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use RelatedModelGuard;

    public function modelIndex(Request $request, Company $company): View
    {
        self::guard('show', $request, $company->id);
        $search = $request->string('search')->value();

        return view('pages.booking.index', [
            'company' => self::$entity,
            'bookings' => Booking::search($search)
                ->whereIn('id', self::$entity->bookings()->select('bookings.id'))
                ->query(fn ($query) => $query->select([...BookingTableMap::values()]))
                ->get(),
        ]);
    }

    public function modelStore(
        StoreBookingRequest $request,
        Company $company
    ): RedirectResponse {
        self::guard('update', $request, $company->id);

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
        Booking $booking
    ): View {
        $this->authorize('show', $booking);

        return view('pages.booking.edit.index', [
            'resource' => $booking,
        ]);
    }

    public function modelUpdate(
        UpdateBookingRequest $request,
        Booking $booking
    ): RedirectResponse {
        $this->authorize('update', $booking);
        $booking->update([...$request->except(['_token', '_method'])]);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Booking updated successfully'
            ));
    }

    public function modelDestroy(
        Request $request,
        Booking $booking
    ): RedirectResponse {
        $booking->delete();

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

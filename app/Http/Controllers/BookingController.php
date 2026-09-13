<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Columns\BookingColumns;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Country;
use App\Models\VehicleMake;
use App\Traits\RelatedModelGuard;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    use RelatedModelGuard;

    public function index(Request $request): View
    {
        $this->authorize('showAll', Booking::class);
        $search = $request->string('search')->value();

        $bookings = Booking::search($search)
            ->whereIn('company_id', Auth::user()->companies()->select('companies.id'))
            ->query(fn ($query) => $query->select([...BookingColumns::values(), 'company_id']))
            ->get();

        return view('pages.booking.index', [
            'bookings' => $bookings,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('store', Booking::class);

        return view('pages.booking.create', [
            'companies' => Auth::user()->companies()->orderBy('id')->get(),
            'countries' => Country::all(),
            'makes' => VehicleMake::all(),
            // 'models' => VehicleModel::all(),
            // 'data' => VehicleData::all(),
            // 'years' => VehicleYear::all(),
        ]);
    }

    public function modelStore(
        StoreBookingRequest $request
    ): RedirectResponse {
        $this->authorize('store', Booking::class);

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

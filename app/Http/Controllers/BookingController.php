<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\FileGroupUpload;
use App\Enums\Columns\BookingColumns;
use App\Enums\Columns\WorkorderColumns;
use App\Enums\Type\FileType;
use App\Http\Requests\StoreBookingClientDataRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Country;
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

    public function modelCreate(Request $request, Company $company): View
    {
        self::guard('update', $request, $company->id);
        $this->authorize('store', Booking::class);

        return view('pages.booking.create', [
            'company' => $company,
            'available_companies' => Auth::user()->companies()->orderBy('id')->get(),
            'countries' => Country::all(),
        ]);
    }

    public function modelStore(
        StoreBookingRequest $request
    ): RedirectResponse {
        $this->authorize('store', Booking::class);

        try {
            $booking = Booking::create([
                ...$request->safe()->all(),
                'advisor_id' => Auth::user()->id,
            ]);
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with(self::flashMessage(
                    'error',
                    'Resource not created',
                    $e->getMessage(),
                ));
        }

        return redirect()->intended(route('bookings.companies.edit', [$booking, $booking->company]))
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
            'booking' => $booking,
            'workorders' => $booking->workorders()->get(WorkorderColumns::values()->toArray()),
        ]);
    }

    public function modelUpdate(
        UpdateBookingRequest $request,
        Booking $booking
    ): RedirectResponse {
        $this->authorize('update', $booking);
        $booking->update([...$request->safe()->all()]);

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

    public function editClientData(Booking $booking): View
    {
        $this->authorize('clientEdit', $booking);

        return view('pages.client.portal.booking.edit', [
            'booking' => (object) $booking->only([
                'id',
                'number',
                'status',
                'service_type',
                'complaint',
                'client_notes',
                'advisor_id',
                'company_id',
                'clientFiles',
            ]),
        ]);
    }

    public function storeClientData(
        StoreBookingClientDataRequest $request,
        Booking $booking,
        FileGroupUpload $fileGroupUpload
    ): RedirectResponse {

        // dd($request->safe()->all(), $booking);

        $booking->update([
            'client_notes' => $request->client_notes,
            'complaint' => $request->complaint,
        ]);

        if ($request->file('files')) {
            $files = $fileGroupUpload->handle(
                FileType::CLIENT_REFERENCE,
                'Client uploaded files',
                $request->file('files'),
            );
            $booking->clientFiles()->attach($files);
        }

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Booking has been updated successfully'
            ));
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use Illuminate\Contracts\View\View;

class BookingController extends Controller
{

    public function index(): void
    {
        //
    }

    public function create(): void
    {
        //
    }

    public function store(StoreBookingRequest $request): void
    {
        //

        # generate client_url_token
        # generate booking number
        # generate based on events booking status
    }

    public function edit(Booking $booking): void
    {
        //
    }

    public function update(UpdateBookingRequest $request, Booking $booking): void
    {
        //
        # re-generate based on event booking status
    }

    public function destroy(Booking $booking): void
    {
        //
    }

    public function clientData(): void
    {
        # grab and validate client_url_token
        # grab client notes
        # grab client files
    }
}

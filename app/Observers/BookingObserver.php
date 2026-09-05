<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Notifications\BookingClientNotification;
use App\Notifications\BookingCreatedNotification;
use App\Notifications\BookingStatusUpdateNotification;
use Illuminate\Support\Facades\Notification;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        $users = $booking->company->users;
        Notification::send($users, new BookingCreatedNotification($booking));

        # CHECKED_IN
        if ($booking->checked_in_at !== null) {
            $booking->status = BookingStatus::CHECKED_IN;
            $booking->save();
        }

        # CONFIRMED
        if ($booking->appointment_start !== null) {
            $booking->status = BookingStatus::CONFIRMED;
            $booking->save();
        }
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {

        if ($booking->wasChanged('status')) {
            $users = $booking->company->users;
            $old = $booking->getOriginal('status');
            Notification::send($users, new BookingStatusUpdateNotification($booking, $old));
            return;
        }

        /**
         * Status protected changes are placed below the above status check
         * in order to avoid infinite loops
         */

        # CHECKED_IN
        if (
            $booking->wasChanged('checked_in_at') &&
            $booking->getOriginal('checked_in_at') === null &&
            $booking->checked_in_at !== null
        ) {
            $booking->status = BookingStatus::CHECKED_IN;
            $booking->save();

            # client notification
            $title = 'Booking with number ' . $booking->number . ' has been check in successfully';
            $messages = [
                'Vehicle with registration ' . $booking->vehicle->registration . ' has been successfully assigned to the booking number stated above.',
                'You can click the button below to see more details about your booking and also add respective notes and/or photos related to the state of the vehicle which can help us in our investigation.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));
        }

        # CONFIRMED
        if (
            $booking->wasChanged('appointment_start') &&
            $booking->getOriginal('appointment_start') === null &&
            $booking->appointment_start !== null
        ) {
            $booking->status = BookingStatus::CONFIRMED;
            $booking->save();
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}

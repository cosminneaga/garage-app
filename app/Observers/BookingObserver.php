<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Booking;
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

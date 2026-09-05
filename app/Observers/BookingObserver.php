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
        if ($this->columnInsertCheck($booking, 'checked_in_at')) {
            $booking->status = BookingStatus::CHECKED_IN;
            $booking->save();

            # client notification
            $title = 'Booking with number ' . $booking->number . ' has been checked in successfully';
            $messages = [
                'Vehicle with registration ' . $booking->vehicle->registration . ' has been successfully assigned to the booking number stated above.',
                'You can click the button below to see more details about your booking and also add respective notes and/or photos related to the state of the vehicle which can help us in our investigation.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));
        }

        # CONFIRMED
        if ($this->columnInsertCheck($booking, 'appointment_start')) {
            $booking->status = BookingStatus::CONFIRMED;
            $booking->save();

            # client notification
            $title = 'Booking with number ' . $booking->number . ' has been confirmed successfully';
            $messages = [
                'Vehicle with registration ' . $booking->vehicle->registration . ' has been successfully assigned to the booking number stated above.',
                'You can click the button below to see more details about your booking and also add respective notes and/or photos related to the state of the vehicle which can help us in our investigation.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));
        }

        # IN_PROGRESS && IN_REVIEW
        # This is manipulated entirely on workorder creation stage in WorkorderObserver

        # CANCELLED
        if ($this->columnInsertCheck($booking, 'cancelled_at')) {
            $booking->status = BookingStatus::CANCELLED;
            $booking->save();

            # client notification
            $title = 'Booking with number ' . $booking->number . ' has been cancelled';
            $messages = [
                'Booking number ' . $booking->number . ' has been cancelled.',
                'Please contact our administration team to book another appointment.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));
        }

        # COMPLETED
        # This status should be triggered by invoicing part of the system
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

    private function columnInsertCheck(Booking $booking, string $column_name): bool
    {
        return $booking->isDirty($column_name) &&
            $booking->getOriginal($column_name) === null;
    }
}

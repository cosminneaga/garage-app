<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Notifications\BookingClientNotification;
use App\Notifications\BookingCreatedNotification;
use App\Notifications\BookingStatusUpdateNotification;
use App\Traits\ObserverHelper;
use Illuminate\Support\Facades\Notification;

class BookingObserver
{
    use ObserverHelper;

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

    public function updated(Booking $booking): void
    {

        $users = $booking->company->users;

        if ($booking->wasChanged('status')) {
            $old = $booking->getOriginal('status');
            Notification::send($users, new BookingStatusUpdateNotification($booking, $old));

            if ($booking->status === BookingStatus::IN_PROGRESS) {
                # client notification
                $title = 'Booking with number ' . $booking->number . ' is in progress';
                $messages = [
                    'Vehicle with registration ' . $booking->vehicle->registration . ' has been successfully assigned to the booking number stated above.',
                    'We just want to let you know that a technician has been assigned to your vehicle.'
                ];
                Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));
            }

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

        # IN_REVIEW
        if ($this->columnInsertCheck($booking, 'in_review_at')) {
            $booking->status = BookingStatus::IN_REVIEW;
            $booking->save();
        }

        # IN_PROGRESS
        if ($this->columnInsertCheck($booking, 'in_progress_at')) {
            $booking->status = BookingStatus::IN_PROGRESS;
            $booking->save();
        }

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

    public function deleted(Booking $booking): void
    {
        //
    }

    public function restored(Booking $booking): void
    {
        //
    }

    public function forceDeleted(Booking $booking): void
    {
        //
    }
}

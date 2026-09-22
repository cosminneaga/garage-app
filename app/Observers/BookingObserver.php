<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Status\BookingStatus;
use App\Models\Booking;
use App\Notifications\BookingClientNotification;
use App\Notifications\BookingCreatedNotification;
use App\Notifications\BookingStatusUpdateNotification;
use App\Traits\ObserverHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class BookingObserver
{
    use ObserverHelper;

    public function created(Booking $booking): void
    {
        $managers = $booking->company->managers;
        Notification::send([...$managers, Auth::user()], new BookingCreatedNotification($booking));

        # CHECKED_IN
        if ($booking->checked_in_at !== null) {
            $booking->status = BookingStatus::CHECKED_IN;
            $booking->save();
            $booking->statuses()->create([
                'status' => $booking->status,
                'description' => 'Status was triggered by inserting value into "checked_in_at" ' . $booking->checked_in_at . ' on creation stage',
            ]);
        }

        # CONFIRMED
        if ($booking->start !== null) {
            $booking->status = BookingStatus::CONFIRMED;
            $booking->save();
            $booking->statuses()->create([
                'status' => $booking->status,
                'description' => 'Status was triggered by inserting value into "start" ' . $booking->start . ' on creation stage',
            ]);
        }
    }

    public function updated(Booking $booking): void
    {
        # send internal notification on each status change
        if ($this->columnChangeCheck($booking, 'status')) {
            $managers = $booking->company->managers;
            $old = $booking->getOriginal('status');
            Notification::send([...$managers, Auth::user()], new BookingStatusUpdateNotification($booking, $old));

            return;
        }

        # CHECKED_IN
        if ($this->columnInsertCheck($booking, 'checked_in_at')) {
            $booking->status = BookingStatus::CHECKED_IN;
            $booking->save();
            $booking->statuses()->create([
                'status' => $booking->status,
                'description' => 'Status was triggered by inserting value into "checked_in_at" ' . $booking->checked_in_at,
            ]);

            # insert into attached vehicle first_visit field
            if ($booking->vehicle->first_visit === null) {
                $booking->vehicle->first_visit = Carbon::now();
                $booking->vehicle->save();
            }


            $title = 'Booking with number ' . $booking->number . ' has been checked in successfully';
            $messages = [
                'Vehicle with registration ' . $booking->vehicle->registration . ' has been successfully assigned to the booking number stated above.',
                'You can click the button below to see more details about your booking and also add respective notes and/or photos related to the state of the vehicle which can help us in our investigation.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));

            return;
        }

        # CONFIRMED
        if ($this->columnInsertCheck($booking, 'start')) {
            $booking->status = BookingStatus::CONFIRMED;
            $booking->save();
            $booking->statuses()->create([
                'status' => $booking->status,
                'description' => 'Status was triggered by inserting value into "start" ' . $booking->start,
            ]);

            $title = 'Booking with number ' . $booking->number . ' has been confirmed successfully';
            $messages = [
                'Vehicle with registration ' . $booking->vehicle->registration . ' has been successfully assigned to the booking number stated above.',
                'You can click the button below to see more details about your booking and also add respective notes and/or photos related to the state of the vehicle which can help us in our investigation.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));

            return;
        }

        # IN_REVIEW
        if ($this->columnInsertCheck($booking, 'in_review_at')) {
            $booking->status = BookingStatus::IN_REVIEW;
            $booking->save();
            $booking->statuses()->create([
                'status' => $booking->status,
                'description' => 'Status was triggered by inserting value into "in_review_at" ' . $booking->in_review_at,
            ]);

            return;
        }

        # IN_PROGRESS
        if ($this->columnInsertCheck($booking, 'in_progress_at')) {
            $booking->status = BookingStatus::IN_PROGRESS;
            $booking->save();
            $booking->statuses()->create([
                'status' => $booking->status,
                'description' => 'Status was triggered by inserting value into "in_progress_at" ' . $booking->in_progress_at,
            ]);

            $title = 'Booking with number ' . $booking->number . ' is in progress';
            $messages = [
                'Vehicle with registration ' . $booking->vehicle->registration . ' has been successfully assigned to the booking number stated above.',
                'We just want to let you know that a technician has been assigned to your vehicle.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));

            return;
        }

        # CANCELLED
        if ($this->columnInsertCheck($booking, 'cancelled_at')) {
            $booking->status = BookingStatus::CANCELLED;
            $booking->save();
            $booking->statuses()->create([
                'status' => $booking->status,
                'description' => 'Status was triggered by inserting value into "cancelled_at" ' . $booking->cancelled_at,
            ]);

            $title = 'Booking with number ' . $booking->number . ' has been cancelled';
            $messages = [
                'Booking number ' . $booking->number . ' has been cancelled.',
                'Please contact our administration team to book another appointment.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));

            return;
        }

        # COMPLETED
        if ($this->columnInsertCheck($booking, 'completed_at')) {
            $booking->status = BookingStatus::COMPLETED;
            $booking->save();
            $booking->statuses()->create([
                'status' => $booking->status,
                'description' => 'Status was triggered by inserting value into "completed_at" ' . $booking->completed_at,
            ]);

            $title = 'Booking with number ' . $booking->number . ' has been finsalised';
            $messages = [
                'Booking number ' . $booking->number . ' has been completed.',
                'Please follow the below link to preview generated invoice.',
            ];
            Notification::send($booking->client, new BookingClientNotification($booking, $title, $messages));

            return;
        }
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

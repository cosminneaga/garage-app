<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\BookingStatus;
use App\Enums\WorkorderStatus;
use App\Models\Workorder;

class WorkorderObserver
{
    /**
     * Handle the Workorder "created" event.
     */
    public function created(Workorder $workorder): void
    {
        $booking = $workorder->booking;
        $booking->status = BookingStatus::IN_PROGRESS;
        $booking->save();
    }

    /**
     * Handle the Workorder "updated" event.
     */
    public function updated(Workorder $workorder): void
    {
        if ($workorder->wasChanged('status')) {
            if ($workorder->status === WorkorderStatus::COMPLETED) {
                $workorder->booking->status = BookingStatus::IN_REVIEW;
                $workorder->booking->save();
            }

            return;
        }
    }

    /**
     * Handle the Workorder "deleted" event.
     */
    public function deleted(Workorder $workorder): void
    {
        //
    }

    /**
     * Handle the Workorder "restored" event.
     */
    public function restored(Workorder $workorder): void
    {
        //
    }

    /**
     * Handle the Workorder "force deleted" event.
     */
    public function forceDeleted(Workorder $workorder): void
    {
        //
    }
}

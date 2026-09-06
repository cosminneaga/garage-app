<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\WorkorderStatus;
use App\Models\Workorder;
use App\Traits\ObserverHelper;
use Carbon\Carbon;

class WorkorderObserver
{
    use ObserverHelper;

    public function created(Workorder $workorder): void
    {
        $workorder->booking->in_progress_at = Carbon::now();
        $workorder->booking->save();
    }

    public function updated(Workorder $workorder): void
    {
        if ($workorder->wasChanged('status')) {
            switch ($workorder->status) {
                case WorkorderStatus::COMPLETED:
                    $workorder->booking->in_review_at = Carbon::now();
                    break;
                case WorkorderStatus::CANCELLED:
                    $workorder->booking->cancelled_at = $workorder->cancelled_at;
                    break;
                default:
                    break;
            }

            return;
        }

        /**
         * Status protected changes are placed below the above status check
         * in order to avoid infinite loops
         */

        # IN_PROGRESS
        if ($this->columnInsertCheck($workorder, 'odometer_on_start')) {
            $workorder->status = WorkorderStatus::IN_PROGRESS;
            $workorder->save();
        }

        # COMPLETED
        if ($this->columnInsertCheck($workorder, 'completed_at')) {
            $workorder->status = WorkorderStatus::COMPLETED;
            $workorder->save();
        }

        # CANCELLED
        if ($this->columnInsertCheck($workorder, 'cancelled_at')) {
            $workorder->status = WorkorderStatus::CANCELLED;
            $workorder->save();
        }
    }

    public function deleted(Workorder $workorder): void
    {
        //
    }

    public function restored(Workorder $workorder): void
    {
        //
    }

    public function forceDeleted(Workorder $workorder): void
    {
        //
    }
}

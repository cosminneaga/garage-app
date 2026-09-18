<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Status\WorkorderStatus;
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
        # IN_PROGRESS
        if ($this->columnInsertCheck($workorder, 'odometer_on_start')) {
            $workorder->status = WorkorderStatus::IN_PROGRESS;
            $workorder->in_progress_at = Carbon::now();
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "odometer_at_start" ' . $workorder->odometer_on_start,
            ]);
            $workorder->saveQuietly();

            return;
        }

        # COMPLETED
        if ($this->columnInsertCheck($workorder, 'odometer_on_finish')) {
            $workorder->status = WorkorderStatus::COMPLETED;
            $workorder->completed_at = Carbon::now();
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "odometer_on_finish" ' . $workorder->odometer_on_finish . ' ,also "completed_at" has been populated with ' . $workorder->completed_at,
            ]);
            $workorder->saveQuietly();

            $workorder->booking->in_review_at = $workorder->completed_at;
            $workorder->booking->save();

            return;
        }

        # CANCELLED
        if ($this->columnInsertCheck($workorder, 'cancelled_at')) {
            $workorder->status = WorkorderStatus::CANCELLED;
            $workorder->cancelled_at = Carbon::now();
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "cancelled_at" ' . $workorder->cancelled_at,
            ]);
            $workorder->saveQuietly();

            $workorder->booking->cancelled_at = $workorder->cancelled_at;
            $workorder->booking->save();

            return;
        }

        # IN_PROGRESS
        if ($this->columnChangeCheck($workorder, 'in_progress_at')) {
            $workorder->status = WorkorderStatus::IN_PROGRESS;
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by changing value into "in_progress_at" from ' . $workorder->getOriginal('in_progress_at') . ' to ' . $workorder->in_progress_at,
            ]);
            $workorder->saveQuietly();

            $workorder->booking->in_progress_at = Carbon::now();
            $workorder->booking->save();

            return;
        }

        # PAUSED
        if ($this->columnChangeCheck($workorder, 'in_pause_at')) {
            $workorder->status = WorkorderStatus::PAUSED;
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by changing value into "in_pause_at" from ' . $workorder->getOriginal('in_pause_at') . ' to ' . $workorder->in_pause_at,
            ]);
            $workorder->saveQuietly();

            return;
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

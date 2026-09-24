<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Status\WorkorderStatus;
use App\Models\WorkorderOperationLabourTime;
use App\Traits\ObserverHelper;
use Carbon\Carbon;
use LogicException;

class WorkorderOperationLabourTimeObserver
{
    use ObserverHelper;

    public function creating(WorkorderOperationLabourTime $time): void
    {
        $wo = $time->operation->workorder;

        # check to stop creating a new time window if there is one present
        if ($time->operation->hasActiveTime()) {
            throw new LogicException('This time window cannot be attached! Another window has been alocated to given operation');
        }

        if ($wo->status !== WorkorderStatus::IN_PROGRESS) {
            $wo->in_progress_at = Carbon::now()->format('d-m-Y H:i');
            $wo->save();

            $wo->statuses()->create([
                'status' => WorkorderStatus::IN_PROGRESS,
                'description' => 'Status was triggered from "WorkorderOperationLabourTime", start was set at ' . $time->start,
            ]);
        }


    }

    public function updated(WorkorderOperationLabourTime $time): void
    {
        $wo = $time->operation->workorder;

        # END
        if ($this->columnInsertCheck($time, 'end')) {
            $wo->in_pause_at = $time->end;
            $wo->save();

            $wo->statuses()->create([
                'status' => WorkorderStatus::PAUSED,
                'description' => 'Status was triggered from "WorkorderOperationLabourTime", end was set at ' . $time->end,
            ]);

            return;
        }
    }

    public function deleted(WorkorderOperationLabourTime $time): void
    {
        //
    }

    public function restored(WorkorderOperationLabourTime $time): void
    {
        //
    }

    public function forceDeleted(WorkorderOperationLabourTime $time): void
    {
        //
    }
}

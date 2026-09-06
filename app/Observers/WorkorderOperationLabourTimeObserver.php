<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\WorkorderStatus;
use App\Models\WorkorderOperationLabourTime;
use App\Traits\ObserverHelper;
use Carbon\Carbon;
use Error;

class WorkorderOperationLabourTimeObserver
{
    use ObserverHelper;

    public function creating(WorkorderOperationLabourTime $time): void
    {
        $wo = $time->operation->workorder;

        # this check stops the creation of another time window if wo has status in progress
        if ($wo->status === WorkorderStatus::IN_PROGRESS) {
            throw new Error('This time window cannot be attached! Another window has been alocated to given workorder');
        }

        $wo->in_progress_at = Carbon::now();
        $wo->save();
    }

    public function updated(WorkorderOperationLabourTime $time): void
    {
        $wo = $time->operation->workorder;

        # END
        if ($this->columnInsertCheck($time, 'end')) {
            $wo->in_pause_at = $time->end;
            $wo->save();
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

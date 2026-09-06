<?php

namespace App\Observers;

use App\Models\WorkorderOperationLabourTime;
use App\Traits\ObserverHelper;
use Carbon\Carbon;

class WorkorderOperationLabourTimeObserver
{
    use ObserverHelper;

    public function created(WorkorderOperationLabourTime $workorderOperationLabourTime): void
    {
        $workorderOperationLabourTime->operation->workorder->in_progress_at = Carbon::now();
        $workorderOperationLabourTime->operation->workorder->save();
    }

    public function updated(WorkorderOperationLabourTime $workorderOperationLabourTime): void
    {
        # END
        if ($this->columnInsertCheck($workorderOperationLabourTime, 'end')) {
            $workorderOperationLabourTime->operation->in_pause_at = $workorderOperationLabourTime->end;
            return;
        }
    }

    public function deleted(WorkorderOperationLabourTime $workorderOperationLabourTime): void
    {
        //
    }

    public function restored(WorkorderOperationLabourTime $workorderOperationLabourTime): void
    {
        //
    }

    public function forceDeleted(WorkorderOperationLabourTime $workorderOperationLabourTime): void
    {
        //
    }
}

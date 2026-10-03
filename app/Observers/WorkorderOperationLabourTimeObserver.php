<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Status\WorkorderStatus;
use App\Models\WorkorderOperationLabourTime;
use App\Services\WorkorderService;
use App\Traits\ObserverHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
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
            App::make(WorkorderService::class, ['model' => $wo])->updateInProgressAtWithStatus(Carbon::now());
        }

        App::make(WorkorderService::class, [ 'model' => $wo ])->refreshCosts();
    }

    public function updated(WorkorderOperationLabourTime $time): void
    {
        $wo = $time->operation->workorder;
        App::make(WorkorderService::class, [ 'model' => $wo ])->refreshCosts();

        # END
        if ($this->columnInsertCheck($time, 'end')) {
            if ($wo->status !== WorkorderStatus::PAUSED) {
                App::make(WorkorderService::class, ['model' => $wo])->updateInPauseAtWithStatus(Carbon::now());
            }
        }
    }
}

<?php

namespace App\Observers;

use App\Models\WorkorderOperation;
use App\Traits\ObserverHelper;

class WorkorderOperationObserver
{
    use ObserverHelper;

    /**
     * Handle the WorkorderOperation "created" event.
     */
    public function created(WorkorderOperation $operation): void
    {
        //
    }

    /**
     * Handle the WorkorderOperation "updated" event.
     */
    public function updated(WorkorderOperation $operation): void
    {
        //
    }

    /**
     * Handle the WorkorderOperation "deleted" event.
     */
    public function deleted(WorkorderOperation $operation): void
    {
        //
    }

    /**
     * Handle the WorkorderOperation "restored" event.
     */
    public function restored(WorkorderOperation $operation): void
    {
        //
    }

    /**
     * Handle the WorkorderOperation "force deleted" event.
     */
    public function forceDeleted(WorkorderOperation $operation): void
    {
        //
    }
}

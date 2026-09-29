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
        // $wo = $operation->workorder;

        // if ($operation->part) {
        //     $wo->part_total_cost += $operation->part->selling_price;
        //     $wo->saveQuietly();
        // }
    }

    /**
     * Handle the WorkorderOperation "updated" event.
     */
    public function updated(WorkorderOperation $operation): void
    {
        // $wo = $operation->workorder;
        // $operations = $wo->operations;

        // $totalHours = 0.00;
        // $totalParts = 0.00;

        // foreach ($operations as $op) {
        //     $totalHours += round($operation->times->sum('minutes') / 60, 2);
        //     $totalParts += $op->part->selling_price;
        // }

        // $wo->labour_total_cost += $wo->labour_total_cost * $totalHours;
        // $wo->part_total_cost += $totalParts;

        // if ($this->columnInsertCheck($operation, 'part')) {
        //     $wo = $operation->workorder;
        //     $wo->part_total_cost += $operation->part->selling_price;
        //     $wo->saveQuietly();

        //     return;
        // }
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

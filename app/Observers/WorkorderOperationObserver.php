<?php

namespace App\Observers;

use App\Models\WorkorderOperation;
use App\Services\WorkorderService;
use App\Traits\ObserverHelper;
use Illuminate\Support\Facades\App;

class WorkorderOperationObserver
{
    use ObserverHelper;

    public function created(WorkorderOperation $operation): void
    {
        App::make(WorkorderService::class, [ 'model' => $operation->workorder ])->refreshCosts();
    }

    public function updated(WorkorderOperation $operation): void
    {
        # update workorder prices
        App::make(WorkorderService::class, [ 'model' => $operation->workorder ])->refreshCosts();
    }
}

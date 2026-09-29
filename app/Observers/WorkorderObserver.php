<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Status\WorkorderStatus;
use App\Models\Workorder;
use App\Notifications\WorkorderAssignedNotification;
use App\Notifications\WorkorderStatusUpdateNotification;
use App\Traits\ObserverHelper;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class WorkorderObserver
{
    use ObserverHelper;

    public function created(Workorder $workorder): void
    {
        $workorder->booking->in_progress_at = Carbon::now()->format('d-m-Y H:i');
        $workorder->booking->save();

        # send internal notification to assigned user
        Notification::send($workorder->technician, new WorkorderAssignedNotification($workorder));
    }

    public function updated(Workorder $workorder): void
    {
        # send internal notification to management on each status change
        if ($this->columnChangeCheck($workorder, 'status')) {
            $this->updatePrices($workorder, 'updated on status change: ' . $workorder->status->value);

            return;
        }

        # IN_PROGRESS
        if ($this->columnInsertCheck($workorder, 'odometer_on_start')) {
            $workorder->status = WorkorderStatus::IN_PROGRESS;
            $workorder->in_progress_at = Carbon::now()->format('d-m-Y H:i');
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "odometer_at_start" ' . $workorder->odometer_on_start,
            ]);
            $workorder->save();

            return;
        }

        # COMPLETED
        if ($this->columnInsertCheck($workorder, 'odometer_on_finish')) {
            $workorder->status = WorkorderStatus::COMPLETED;
            $workorder->completed_at = Carbon::now()->format('d-m-Y H:i');
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "odometer_on_finish" ' . $workorder->odometer_on_finish . ' ,also "completed_at" has been populated with ' . $workorder->completed_at,
            ]);
            $workorder->save();

            $workorder->booking->in_review_at = $workorder->completed_at;
            $workorder->booking->save();

            $managers = $workorder->booking->company->managers;
            $this->sendManagersNotification($managers, $workorder);

            return;
        }

        # CANCELLED
        if ($this->columnInsertCheck($workorder, 'cancelled_at')) {
            $workorder->status = WorkorderStatus::CANCELLED;
            $workorder->cancelled_at = Carbon::now()->format('d-m-Y H:i');
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "cancelled_at" ' . $workorder->cancelled_at,
            ]);
            $workorder->save();

            $workorder->booking->cancelled_at = $workorder->cancelled_at;
            $workorder->booking->save();

            $managers = $workorder->booking->company->managers;
            $this->sendManagersNotification($managers, $workorder);

            return;
        }

        # IN_PROGRESS
        if ($this->columnChangeCheck($workorder, 'in_progress_at')) {
            $workorder->status = WorkorderStatus::IN_PROGRESS;
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by changing value into "in_progress_at" from ' . $workorder->getOriginal('in_progress_at') . ' to ' . $workorder->in_progress_at,
            ]);
            $workorder->save();

            $workorder->booking->in_progress_at = Carbon::now()->format('d-m-Y H:i');
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
            $workorder->save();

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

    protected function sendManagersNotification(Collection $managers, Workorder $workorder): void
    {
        Notification::send($managers, new WorkorderStatusUpdateNotification($workorder, $workorder->getOriginal('status')));
    }

    protected function updatePrices(Workorder $workorder, string $message): void
    {
        # on each update reflect total prices
        $operations = $workorder->operations;
        $totalHours = 0.00;
        $totalParts = 0.00;

        foreach ($operations as $operation) {
            $totalHours += round($operation->times?->sum('minutes') / 60, 2);
            $totalParts += $operation->part?->selling_price;
        }

        $workorder->labour_total_cost = $workorder->labour_rate * $totalHours;
        $workorder->part_total_cost = $totalParts;
        $workorder->saveQuietly();


        Log::info($message);
        Log::info(json_encode([
            'id' => $workorder->id,
            'title' => $workorder->title,
            'status' => $workorder->status,
            'labour_rate' => $workorder->labour_rate,
            'labour_total_cost' => $workorder->labour_total_cost,
            'part_total_cost' => $workorder->part_total_cost,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_LINE_TERMINATORS));
    }
}

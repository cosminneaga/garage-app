<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Status\WorkorderStatus;
use App\Models\Workorder;
use App\Notifications\WorkorderAssignedNotification;
use App\Services\WorkorderService;
use App\Traits\ObserverHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class WorkorderObserver
{
    use ObserverHelper;

    public function created(Workorder $workorder): void
    {
        # send internal notification to assigned user
        Notification::send($workorder->technician, new WorkorderAssignedNotification($workorder));

        if ($workorder->booking) {
            $workorder->booking->in_progress_at = Carbon::now()->format('d-m-Y H:i');
            $workorder->booking->save();
        }
    }

    public function updated(Workorder $workorder): void
    {
        # IN_PROGRESS
        if ($this->columnInsertCheck($workorder, 'odometer_on_start')) {
            $workorder->status = WorkorderStatus::IN_PROGRESS;
            $workorder->in_progress_at = Carbon::now()->format('d-m-Y H:i');
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "odometer_at_start" ' . $workorder->odometer_on_start,
            ]);
            $workorder->saveQuietly();
        }

        # COMPLETED
        if ($this->columnInsertCheck($workorder, 'odometer_on_finish')) {
            $workorder->status = WorkorderStatus::COMPLETED;
            $workorder->completed_at = Carbon::now()->format('d-m-Y H:i');
            App::make(WorkorderService::class, ['model' => $workorder])->sendStatusUpdateNotificationToManagement();

            $workorder->saveQuietly();
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "odometer_on_finish" ' . $workorder->odometer_on_finish . ' ,also "completed_at" has been populated with ' . $workorder->completed_at,
            ]);

            App::make(WorkorderService::class, ['model' => $workorder])->refreshCosts();

            if ($workorder->booking) {
                $workorder->booking->in_review_at = $workorder->completed_at;
                $workorder->booking->save();
            }
        }

        # CANCELLED
        if ($this->columnInsertCheck($workorder, 'cancelled_at')) {
            $workorder->status = WorkorderStatus::CANCELLED;
            $workorder->cancelled_at = Carbon::now()->format('d-m-Y H:i');
            App::make(WorkorderService::class, ['model' => $workorder])->sendStatusUpdateNotificationToManagement();

            $workorder->saveQuietly();
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by inserting value into "cancelled_at" ' . $workorder->cancelled_at,
            ]);

            if ($workorder->booking) {
                $workorder->booking->cancelled_at = $workorder->cancelled_at;
                $workorder->booking->save();
            }
        }

        # IN_PROGRESS
        if ($this->columnChangeCheck($workorder, 'in_progress_at')) {
            $workorder->status = WorkorderStatus::IN_PROGRESS;
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by changing value into "in_progress_at" from ' . $workorder->getOriginal('in_progress_at') . ' to ' . $workorder->in_progress_at,
            ]);
            $workorder->saveQuietly();

            if ($workorder->booking) {
                $workorder->booking->in_progress_at = Carbon::now()->format('d-m-Y H:i');
                $workorder->booking->save();
            }
        }

        # PAUSED
        if ($this->columnChangeCheck($workorder, 'in_pause_at')) {
            $workorder->status = WorkorderStatus::PAUSED;
            $workorder->statuses()->create([
                'status' => $workorder->status,
                'description' => 'Status was trigger by changing value into "in_pause_at" from ' . $workorder->getOriginal('in_pause_at') . ' to ' . $workorder->in_pause_at,
            ]);
            $workorder->saveQuietly();
        }
    }
}

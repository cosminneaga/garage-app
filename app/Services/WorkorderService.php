<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Status\WorkorderStatus;
use App\Models\Workorder;
use App\Notifications\WorkorderStatusUpdateNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class WorkorderService
{
    public function __construct(protected Workorder $model)
    {
        //
    }

    public function refreshCosts(): void
    {
        $operations = $this->model->operations;
        $totalHours = 0.00;
        $totalParts = 0.00;

        foreach ($operations as $operation) {
            $totalHours += round($operation->times?->sum('minutes') / 60, 2);
            $totalParts += $operation->part?->selling_price;
        }

        $this->model->update([
            'labour_total_cost' => $this->model->labour_rate * $totalHours,
            'part_total_cost' => $totalParts,
        ]);
    }

    public function updateInProgressAtWithStatus(Carbon $time): void
    {
        $timeFormatted = $time->format('d-m-Y H:i');
        $this->model->update([
            'in_progress_at' => $timeFormatted,
        ]);

        $this->model->statuses()->create([
            'status' => WorkorderStatus::IN_PROGRESS,
            'description' => 'Start was set at ' . $timeFormatted,
        ]);
    }

    public function updateInPauseAtWithStatus(Carbon $time): void
    {
        $timeFormatted = $time->format('d-m-Y H:i');
        $this->model->update([
            'in_pause_at' => $timeFormatted,
        ]);

        $this->model->statuses()->create([
            'status' => WorkorderStatus::PAUSED,
            'description' => 'End was set at ' . $timeFormatted,
        ]);
    }

    public function sendStatusUpdateNotificationToManagement(): void
    {
        $managers = $this->model->company->managers;
        Notification::send($managers, new WorkorderStatusUpdateNotification($this->model, $this->model->getOriginal('status')));
    }
}

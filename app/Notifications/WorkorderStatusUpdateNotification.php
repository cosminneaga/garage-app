<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\Status\WorkorderStatus;
use App\Models\Workorder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkorderStatusUpdateNotification extends Notification
{
    use Queueable;

    public function __construct(public Workorder $workorder, public WorkorderStatus $oldStatus)
    {
        //
    }

    public function via(): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toDatabase(): array
    {
        return $this->toArray();
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray());
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())->markdown('mail.workorder-status-update-notification');
    }

    public function toArray(): array
    {
        return [
            'type' => 'workorder.status.updated',
            'title' => 'Workorder ' . $this->workorder->number . ' status has changed',
            'message' => 'Workorder with number ' . $this->workorder->number . ' status has been updated from "' . $this->oldStatus->label() . '" to "' . $this->workorder->status->label() . '"',
            'url' => route('workorders.bookings.edit', $this->workorder, $this->workorder->booking),
        ];
    }
}

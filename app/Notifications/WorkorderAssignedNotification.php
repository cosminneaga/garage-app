<?php

namespace App\Notifications;

use App\Models\Workorder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkorderAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Workorder $workorder
    ) {}

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
        return (new MailMessage)
            ->subject('Workorder ' . $this->workorder->number)
            ->markdown('mail.generic', $this->toArray());
    }

    public function toArray(): array
    {
        return [
            'type' => 'workorder.technician.assigned',
            'title' => 'Workorder ' . $this->workorder->number . ' assignation',
            'messages' => [
                'Workorder with number: ' . $this->workorder->number . ' has been assigned to you',
                'Current status: ' . $this->workorder->status->label(),
                'Technician: ' . $this->workorder->technician->name,
                'This workorder is now ready to have operations attached, please use the given screen to create as many operations needed with active time of labour',
            ],
            'url' => route('workorders.bookings.edit', [$this->workorder, $this->workorder->booking]),
            'button_text' => 'Go to workorder',
        ];
    }
}

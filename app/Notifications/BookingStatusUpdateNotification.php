<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdateNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking, public BookingStatus $oldStatus)
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
        return (new MailMessage())
            ->subject('Booking ' . $this->booking->number . ' status has changed')
            ->markdown('mail.booking-status-update-notification', $this->toArray());
    }

    public function toArray(): array
    {
        return [
            'type' => 'booking.status.updated',
            'title' => 'Booking ' . $this->booking->number . ' status updated',
            'message' => 'Booking with number: ' . $this->booking->number . ' status has been updated from "' . $this->oldStatus->value . '" to "' . $this->booking->status->value . '"',
            'url' => route('bookings.edit', $this->booking),
        ];
    }
}

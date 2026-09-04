<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking)
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
            ->subject('New booking created')
            ->markdown('mail.booking-created-notification', $this->toArray());
    }

    public function toArray(): array
    {
        return [
            'type' => 'booking.created',
            'title' => 'Booking ' . $this->booking->number . ' created',
            'message' => 'Booking with number: ' . $this->booking->number . ' has been created and added to company: ' . $this->booking->company->name,
            'url' => route('bookings.edit', $this->booking),
        ];
    }
}

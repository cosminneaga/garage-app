<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingClientNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking, public string $title, public array $messages)
    {
        //
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject('Hey in regards with your booking ' . $this->booking->number)
            ->markdown('mail.booking-client-notification', [
                'title' => $this->title,
                'messages' => $this->messages,
                'url' => '#',
            ]);
    }
}

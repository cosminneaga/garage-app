<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExampleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        $url = route('bookings.edit', $this->booking);

        return [
            'type' => 'example.notification',
            'title' => 'Example BOOKING Notification',
            'message' => 'A new booking has been created.',
            'booking_id' => $this->booking->id,
            'url' => $url,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $url = url('/' . $this->booking->getTable() . '/' . $this->booking->id);

        return new BroadcastMessage([
            'type' => 'example.notification',
            'title' => 'Example BOOKING Notification',
            'message' => 'A new booking has been created.',
            'booking_id' => $this->booking->id,
            'url' => $url,
        ]);
    }

    public function toMail(object $notifiable): MailMessage
    {

        $url = url('/booking/' . $this->booking->id);

        return (new MailMessage())
            ->subject('Example Notification on Booking')
            ->markdown('mail.example', [
                'url' => $url,
                'title' => 'Example BOOKING Notification',
                'booking_id' => $this->booking->id,
                'booking_number' => $this->booking->number,
                'test' => 'testing',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [

        ];
    }

    public function databaseType(object $notifiable): string
    {
        return 'example-notification';
    }

    public function initialDatabaseReadAtValue(): ?Carbon
    {
        return null;
    }
}

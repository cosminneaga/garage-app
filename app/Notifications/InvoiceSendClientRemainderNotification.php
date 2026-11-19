<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceSendClientRemainderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Invoice $invoice)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject('Hey in regards with your due invoice')
            ->markdown('mail.generic', [
                'title' => 'Invoice number: ' . $this->invoice->number,
                'messages' => [
                    'The invoice stated above is due on date: ' . $this->invoice->due_date,
                    'The amount is: ' . $this->invoice->amount_due,
                    'Access your account using the button below to view details about your invoice.',
                ],
                'url' => '#',
                'button_text' => 'See due invoice details',
            ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyClientNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Client $client,
        public string $title,
        public array $messages
    ) {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject('Hey your account has been created successfully')
            ->markdown('mail.generic-mail', [
                'title' => $this->title,
                'messages' => $this->messages,
                'button_text' => 'Go to your account',
                'url' => '#',
            ]);
    }
}

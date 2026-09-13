<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Client $client
    ) {
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
            ->subject('Client created')
            ->markdown('mail.generic-mail', $this->toArray());
    }

    public function toArray(): array
    {
        return [
            'type' => 'clients.companies.created',
            'title' => 'Client ' . $this->client->name . ' has been created',
            'messages' => [
                'A new client has been created.',
                'Also an account has been created for the entitled client',
                'Name: ' . $this->client->name,
                'Email: ' .$this->client->email,
                'Access token: ' . $this->client->access_token,
                'Company attached to: ' . $this->client->companies()->first()->name,
            ],
            'url' => '#',
            'button_text' => 'Go to client',
        ];
    }
}

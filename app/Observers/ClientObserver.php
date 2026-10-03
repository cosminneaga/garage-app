<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Client;
use App\Notifications\ClientCreatedNotification;
use App\Notifications\NotifyClientNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ClientObserver
{
    public function created(Client $client): void
    {
        $password = Str::password(16);
        $client->updateQuietly([
            'password' => $password,
        ]);

        $title = 'Your user has been created in Garage App';
        $messages = [
            'Name: ' . $client->name,
            'Email: ' .$client->email,
            'Password: ' . $password,
            'Access token: ' . $client->access_token,
            'Use your email and password to change your password.',
        ];
        Notification::send($client, new NotifyClientNotification($client, $title, $messages));
        Notification::send(Auth::user(), new ClientCreatedNotification($client));
    }
}

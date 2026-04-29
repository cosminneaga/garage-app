<?php

namespace App\Actions;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserContactStoreAction
{
    public function handle(array $attributes, User $user): void
    {
        DB::transaction(function () use ($attributes, $user) {
            $contact = Contact::updateOrCreate(
                ['email' => $attributes['email']],
                $attributes
            );

            if (!$user->contacts()->find($contact->id)) {
                $user->contacts()->attach($contact);
            }
        });
    }
}

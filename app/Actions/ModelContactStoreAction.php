<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelContactStoreAction
{
    public function handle(array $attributes, Model $model): void
    {
        DB::transaction(function () use ($attributes, $model) {
            $contact = Contact::updateOrCreate(
                ['email' => $attributes['email']],
                $attributes
            );

            if (! $model->contacts()->find($contact->id)) {
                $model->contacts()->attach($contact);
            }
        });
    }
}

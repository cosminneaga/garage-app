<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Contact;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class ModelContactStoreAction
{
    public function handle(array $attributes, Model $model): Throwable|Contact
    {
        $exists = Contact::where('email', $attributes['email'])->exists();
        if ($exists) {
            throw new Exception('Contact information already exists under same email');
        }

        return DB::transaction(function () use ($attributes, $model) {
            $contact = Contact::create($attributes);
            $model->contacts()->attach($contact);

            return $contact;
        });
    }
}

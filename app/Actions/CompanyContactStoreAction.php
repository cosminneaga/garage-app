<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class CompanyContactStoreAction
{
    public function handle(array $attributes, Company $company): void
    {
        DB::transaction(function () use ($attributes, $company) {
            $contact = Contact::updateOrCreate(
                ['email' => $attributes['email']],
                $attributes
            );

            if (! $company->contacts()->find($contact->id)) {
                $company->contacts()->attach($contact);
            }
        });
    }
}

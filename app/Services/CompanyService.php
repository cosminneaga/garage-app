<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function __construct()
    {
        //
    }

    public function createOne(array $attributes, string|int $ownerId): void
    {
        $contact = $attributes['contact'];
        $address = collect($attributes['address'])
            ->merge(['country_id' => $attributes['address_country_id']])
            ->toArray();

        $company = collect($attributes)
            ->only([
                'name',
                'tax_id',
                'registration_number',
                'tax_value',
                'invoice_prefix',
            ])
            ->toArray();

        DB::transaction(function () use ($contact, $address, $company, $ownerId) {
            $iCompany = Company::create($company);
            $iCompany->users()->attach($ownerId);
            $iCompany->addresses()->attach(Address::updateOrCreate(
                ['number' => $address['number'], 'street' => $address['street'], 'postcode' => $address['postcode']],
                $address
            ));
            $iCompany->contacts()->attach(Contact::updateOrCreate(
                ['email' => $contact['email']],
                $contact
            ));
        });
    }

    public function getMyCompanies(User $user): BelongsToMany
    {
        // !TODO: create a functionality to retrieve all companies that the user is attached to
        if ($user->hasRole(UserRole::USER_EDITOR) || $user->hasRole(UserRole::USER_VIEWER)) {
            // !TODO: this is not quite right as user which is not manager should only retrieve the companies is attached to not all of them
            $manager = $user->managers()->first();
            return $manager->companies();
        }

        return $user->companies();
    }
}

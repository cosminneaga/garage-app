<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct()
    {
        //
    }

    public function getRelatedAddresses(User $user): array
    {
        return [
            'user' => $user->addresses()->get(),
            'companies' => $user->companies()->get()->map(fn ($company) => [
                'name' => $company->name,
                'addresses' => $company->addresses()->get(),
            ]),
        ];
    }

    public function createOne(array $attributes, User $manager): void
    {
        //
        $contact = $attributes['contact'];
        $address = collect($attributes['address'])
            ->merge(['country_id' => $attributes['address_country_id']])
            ->toArray();

        $user = collect($attributes)
            ->only([
                'name',
                'email',
                'password'
            ])
            ->toArray();
        $role = $attributes['role'];

        DB::transaction(function () use ($contact, $address, $user, $manager, $role) {
            $iUser = User::create($user);
            $iUser->assignRole($role);
            $manager->team()->attach($iUser);
            $iUser->addresses()->attach(Address::updateOrCreate(
                ['number' => $address['number'], 'street' => $address['street'], 'postcode' => $address['postcode']],
                $address
            ));
            $iUser->contacts()->attach(Contact::updateOrCreate(
                ['email' => $contact['email']],
                $contact
            ));
        });
    }
}

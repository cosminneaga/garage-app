<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserAddressStoreAction
{
    public function handle(array $attributes, User $user): void
    {
        DB::transaction(function () use ($attributes, $user) {
            $address = Address::updateOrCreate(
                [
                    'number' => $attributes['number'],
                    'street' => $attributes['street'],
                    'postcode' => $attributes['postcode'],
                    'country_id' => $attributes['country_id'],
                ],
                $attributes
            );

            if (! $user->addresses()->find($address->id)) {
                $user->addresses()->attach($address);
            }
        });
    }
}

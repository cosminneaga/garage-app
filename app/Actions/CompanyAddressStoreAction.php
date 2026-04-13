<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyAddressStoreAction
{
    public function __construct()
    {
        // throw new \Exception('Not implemented');
    }

    public function handle(array $attributes, Company $company): void
    {
        DB::transaction(function () use ($attributes, $company) {
            $address = Address::updateOrCreate(
                [
                    'number' => $attributes['number'],
                    'street' => $attributes['street'],
                    'postcode' => $attributes['postcode'],
                    'country_id' => $attributes['country_id'],
                ],
                $attributes
            );

            if (! $company->addresses()->find($address->id)) {
                $company->addresses()->attach($address);
            }
        });
    }
}

<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Supplier;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SupplierStoreAction
{
    public function handle(array $attributes, Company $company): void
    {
        $data['contact'] = $attributes['contact'];
        $data['contact']['info'] = $attributes['contact_info'];

        $data['address'] = collect($attributes['address'])
            ->merge(['country_id' => $attributes['address_country_id']])
            ->toArray();

        $data['supplier'] = collect($attributes)
            ->only([
                'name',
                'type',
                'code',
                'tax_id',
                'registration_number',
            ])
            ->toArray();

        if ($company->findSupplierByName($data['supplier']['name']) instanceof Supplier) {
            return;
        }

        DB::transaction(function () use ($data, $company) {

            $contact = Contact::updateOrCreate(
                ['email' => Arr::get($data, 'contact.email')],
                $data['contact'],
            );
            $address = Address::updateOrCreate(
                [
                    'number' => Arr::get($data, 'address.number'),
                    'street' => Arr::get($data, 'address.street'),
                    'postcode' => Arr::get($data, 'address.postcode'),
                ],
                $data['address'],
            );

            $supplier = Supplier::create($data['supplier']);
            $supplier->contacts()->attach($contact);
            $supplier->addresses()->attach($address);
            $company->suppliers()->attach($supplier);
        });
    }
}

<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SupplierStoreAction
{
    public function handle(array $attributes, Company $company): Supplier
    {

        if (!Arr::has($attributes, 'contact') || !Arr::has($attributes, 'address')) {
            throw new Exception('Address & Contact are required when Supplier data is stored');
        }

        $data['contact'] = $attributes['contact'];
        $data['address'] = $attributes['address'];

        $data['supplier'] = collect($attributes)
            ->only([
                'name',
                'type',
                'code',
                'tax_id',
                'registration_number',
            ])
            ->toArray();

        // if supplier exists and is already attached to given company
        $exists = $company->findSupplierByName($data['supplier']['name']);
        if ($exists instanceof Supplier) {
            return $exists;
        }

        return DB::transaction(function () use ($data, $company) {

            $supplier = Supplier::create($data['supplier']);
            $supplier->address()->associate(Address::create($data['address']))->save();
            $supplier->contact()->associate(Contact::create($data['contact']))->save();
            $company->suppliers()->attach($supplier);

            return $supplier;
        });
    }
}

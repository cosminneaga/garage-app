<?php

namespace Tests\Unit\Actions;

use App\Actions\SupplierStoreAction;
use App\Enums\SupplierType;
use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->admin->assignRole(UserRole::USER_ADMIN->value);

    $this->company = Company::factory()->create();
    $this->admin->companies()->attach($this->company);

    $this->country = Country::factory()->create();

    $this->adminAction = new SupplierStoreAction($this->admin);
});

test('should store supplier', function () {
    $this->adminAction->handle([
        'name' => 'Supplier Test',
        'type' => SupplierType::DISTRIBUTOR->value,
        'code' => 'SUP0463',
        'tax_id' => '47284728342',
        'registration_number' => '098049849283',
        'address' => [
            'number' => '212',
            'street' => 'Sunflower Street',
            'postcode' => 'B546BNN',
            'extra' => 'Extra Information',
            'coordinates' => null,
            'country_id' => $this->country->id,
        ],
        'contact' => [
            'mobile' => '0772993822',
            'landline' => '0112737728',
            'email' => 'contact@garage.com',
            'url' => 'http://example.com',
            'info' => 'Information'
        ],
    ], $this->company);

    $suppliers = Supplier::all();
    $addresses = Address::all();
    $contacts = Contact::all();
    expect($suppliers)->toHaveCount(1);
    expect($addresses)->toHaveCount(1);
    expect($contacts)->toHaveCount(1);

    expect($this->company->suppliers)->toHaveCount(1);
});

test('should not store supplier if already is attached to specific company', function () {
    $this->company->suppliers()->attach(Supplier::factory()->create([
        'name' => 'Supplier Test',
    ]));

    $this->adminAction->handle([
        'name' => 'Supplier Test',
        'type' => SupplierType::DISTRIBUTOR->value,
        'code' => 'SUP0463',
        'tax_id' => '47284728342',
        'registration_number' => '098049849283',
        'address' => [
            'number' => '212',
            'street' => 'Sunflower Street',
            'postcode' => 'B546BNN',
            'extra' => 'Extra Information',
            'coordinates' => null,
            'country_id' => $this->country->id,
        ],
        'contact' => [
            'mobile' => '0772993822',
            'landline' => '0112737728',
            'email' => 'contact@garage.com',
            'url' => 'http://example.com',
            'info' => 'Information'
        ],
    ], $this->company);

    $suppliers = Supplier::all();
    expect($suppliers)->toHaveCount(1);

    expect($this->company->suppliers)->toHaveCount(1);
});

test('should store supplier if supplier with similar name exists but is not attached to company', function () {
    Supplier::factory()->create([
        'name' => 'Supplier Test',
    ]);

    $this->adminAction->handle([
        'name' => 'Supplier Test',
        'type' => SupplierType::DISTRIBUTOR->value,
        'code' => 'SUP0463',
        'tax_id' => '47284728342',
        'registration_number' => '098049849283',
        'address' => [
            'number' => '212',
            'street' => 'Sunflower Street',
            'postcode' => 'B546BNN',
            'extra' => 'Extra Information',
            'coordinates' => null,
            'country_id' => $this->country->id,
        ],
        'contact' => [
            'mobile' => '0772993822',
            'landline' => '0112737728',
            'email' => 'contact@garage.com',
            'url' => 'http://example.com',
            'info' => 'Information'
        ],
    ], $this->company);

    $suppliers = Supplier::all();
    expect($suppliers)->toHaveCount(2);

    expect($this->company->suppliers)->toHaveCount(1);
});


test('should link already existing address & contact, even if suppliers are not linked through same company', function () {
    $address = Address::factory()->create([
        'country_id' => $this->country,
        'coordinates' => null,
    ]);
    $contact = Contact::factory()->create();
    $supplier = Supplier::factory()->create([
        'name' => 'Supplier Test',
    ]);
    $supplier->addresses()->attach($address);
    $supplier->contacts()->attach($contact);

    $this->adminAction->handle([
        'name' => 'Supplier Testing',
        'type' => SupplierType::DISTRIBUTOR->value,
        'code' => 'SUP0463',
        'tax_id' => '47284728342',
        'registration_number' => '098049849283',
        'address' => collect($address)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'contact' => collect($contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ], $this->company);

    $suppliers = Supplier::all();
    $addresses = Address::all();
    $contacts = Contact::all();
    expect($suppliers)->toHaveCount(2);
    expect($addresses)->toHaveCount(1);
    expect($contacts)->toHaveCount(1);

    expect($this->company->suppliers)->toHaveCount(1);
});

test('should link already existing address & contact, even if suppliers are linked through same company', function () {
    $address = Address::factory()->create([
        'country_id' => $this->country,
        'coordinates' => null,
    ]);
    $contact = Contact::factory()->create();
    $supplier = Supplier::factory()->create([
        'name' => 'Supplier Test',
    ]);
    $supplier->addresses()->attach($address);
    $supplier->contacts()->attach($contact);
    $this->company->suppliers()->attach($supplier);

    $this->adminAction->handle([
        'name' => 'Supplier Testing',
        'type' => SupplierType::DISTRIBUTOR->value,
        'code' => 'SUP0463',
        'tax_id' => '47284728342',
        'registration_number' => '098049849283',
        'address' => collect($address)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'contact' => collect($contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ], $this->company);

    $suppliers = Supplier::all();
    $addresses = Address::all();
    $contacts = Contact::all();
    expect($suppliers)->toHaveCount(2);
    expect($addresses)->toHaveCount(1);
    expect($contacts)->toHaveCount(1);

    expect($this->company->suppliers)->toHaveCount(2);
});

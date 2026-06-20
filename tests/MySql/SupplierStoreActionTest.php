<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Actions\SupplierStoreAction;
use App\Dto\Coordinates;
use App\Enums\SupplierType;
use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->company = Company::factory()->create();
    $this->administrator->companies()->attach($this->company);

    $this->country = Country::factory()->create();
    $this->action = new SupplierStoreAction();

    $this->address = [
        'street_number' => '212',
        'street' => 'Sunflower Street',
        'postcode' => 'B546BNN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(7.4343434, 64.89887832),
    ];

    $this->contact = [
        'mobile' => '0772993822',
        'landline' => '0112737728',
        'email' => 'contact@garage.com',
        'url' => 'http://example.com',
        'info' => 'Information',
    ];
});

test('should store supplier', function () {
    $this->action->handle([
        'name' => 'Supplier Test',
        'type' => SupplierType::DISTRIBUTOR->value,
        'code' => 'SUP0463',
        'tax_id' => '47284728342',
        'registration_number' => '098049849283',
        'address' => $this->address,
        'contact' => $this->contact,
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

    $this->action->handle([
        'name' => 'Supplier Test',
        'type' => SupplierType::DISTRIBUTOR->value,
        'code' => 'SUP0463',
        'tax_id' => '47284728342',
        'registration_number' => '098049849283',
        'address' => $this->address,
        'contact' => $this->contact,
    ], $this->company);

    $suppliers = Supplier::all();
    expect($suppliers)->toHaveCount(1);

    expect($this->company->suppliers)->toHaveCount(1);
});

test('should store supplier if supplier with similar name exists but is not attached to company', function () {
    Supplier::factory()->create([
        'name' => 'Supplier Test',
    ]);

    $this->action->handle([
        'name' => 'Supplier Test',
        'type' => SupplierType::DISTRIBUTOR->value,
        'code' => 'SUP0463',
        'tax_id' => '47284728342',
        'registration_number' => '098049849283',
        'address' => $this->address,
        'contact' => $this->contact,
    ], $this->company);

    $suppliers = Supplier::all();
    expect($suppliers)->toHaveCount(2);

    expect($this->company->suppliers)->toHaveCount(1);
});

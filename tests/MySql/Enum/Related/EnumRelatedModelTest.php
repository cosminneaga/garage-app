<?php

use App\Policies\UserPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\AddressPolicy;
use App\Enums\Related\RelatedModel;
use App\Models\Address;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;

test('entity: get entity by id', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();
    $supplier = Supplier::factory()->create();
    $address = Address::factory()->create();

    // dd($address->getAttributes(), RelatedModel::ADDRESS->entity($address->id)->getAttributes());

    expect(RelatedModel::USER->entity($user->id)->getAttributes())
        ->toMatchArray($user->getAttributes());
    expect(RelatedModel::COMPANY->entity($company->id)->getAttributes())
        ->toMatchArray($company->getAttributes());
    expect(RelatedModel::SUPPLIER->entity($supplier->id)->getAttributes())
        ->toMatchArray($supplier->getAttributes());
    expect(RelatedModel::ADDRESS->entity($address->id)->except('coordinates'))
        ->toMatchArray($address->except('coordinates'));
});

test('tableName: get tableName', function () {
    expect(RelatedModel::USER->tableName())->toEqual('users');
    expect(RelatedModel::COMPANY->tableName())->toEqual('companies');
    expect(RelatedModel::SUPPLIER->tableName())->toEqual('suppliers');
    expect(RelatedModel::ADDRESS->tableName())->toEqual('addresses');
});

test('instance: get model instance', function () {
    expect(RelatedModel::USER->instance())->toEqual(User::class);
    expect(RelatedModel::COMPANY->instance())->toEqual(Company::class);
    expect(RelatedModel::SUPPLIER->instance())->toEqual(Supplier::class);
    expect(RelatedModel::ADDRESS->instance())->toEqual(Address::class);
});

test('policy: get policy instance', function () {
    expect(RelatedModel::USER->policy())->toEqual(UserPolicy::class);
    expect(RelatedModel::COMPANY->policy())->toEqual(CompanyPolicy::class);
    expect(RelatedModel::SUPPLIER->policy())->toEqual(SupplierPolicy::class);
    expect(RelatedModel::ADDRESS->policy())->toEqual(AddressPolicy::class);
});

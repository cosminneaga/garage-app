<?php

use App\Actions\SupplierStoreAction;
use App\Enums\SupplierType;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    $this->country = Country::factory()->create();
});

test('handle: store a supplier & link to company', function () {
    $company = Company::factory()->create();

    App::make(SupplierStoreAction::class)->handle([
        'name' => 'Kirlin-Reigner',
        'code' => 'NIMACODE43',
        'type' => SupplierType::DISTRIBUTOR->value,
        'tax_id' => '123456',
        'registration_number' => '123456',
        'address' => [
            'street_number' => '76274',
            'street' => 'Buster Harbors',
            'postcode' => '51040-6389',
            'building' => '72760',
            'floor' => '857',
            'unit' => '36012',
            'country_id' => $this->country->id,
        ],
        'contact' => [
            'mobile' => '+19792815648',
            'landline' => '+1.276.336.3098',
            'email' => 'kuphal.thora@example.net',
            'url' => 'http://harvey.com/quidem-ea-velit-laborum',
            'info' => 'Quasi ut.',
        ],
    ], $company);

    expect($company->suppliers)->toHaveCount(1);
});

test('handle: throw error when contact/address are missing', function () {
    $company = Company::factory()->create();

    expect(fn () => App::make(SupplierStoreAction::class)->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
    ], $company))->toThrow('Address & Contact are required when Company data is stored');
});

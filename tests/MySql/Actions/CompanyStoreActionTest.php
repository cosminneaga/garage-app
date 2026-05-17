<?php

use App\Actions\CompanyStoreAction;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('company should be created along with address & contact', function () {
    $user = User::factory()->create([
        'name' => 'Manager User',
    ]);
    $country = Country::factory()->create();

    $file = UploadedFile::fake()->image('avatar.jpg');
    $dataset = [
        'contact' => [
            'mobile' => '0278122992',
            'landline' => '289993-44201',
            'email' => 'test@email.com',
            'url' => 'http://example.com',
        ],
        'contact_info' => 'INFO',
        'address' => [
            'number' => 243,
            'street' => 'Flowers Street',
            'postcode' => 344343,
            'coordinates' => [
                'latitude' => '46.95195',
                'longitude' => '-23.17107',
            ],
        ],
        'address_country_id' => $country->id,
        'name' => 'Company LTD',
        'tax_id' => 378273823,
        'registration_number' => 7382378732,
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $file,
    ];

    $action = new CompanyStoreAction($user);
    $action->handle($dataset);

    $company = Company::with([
        'addresses',
        'contacts',
    ])->whereName('Company LTD')->first();

    expect($company)->toMatchArray([
        'name' => 'Company LTD',
    ]);
    expect($company->addresses)->toHaveCount(1);
    expect($company->contacts)->toHaveCount(1);
});

test('company address/contact should be updated and linked to a new company, if has same coordinates/email', function () {
    $user = User::factory()->create([
        'name' => 'Manager User',
    ]);
    $country = Country::factory()->create();

    $dataset = [
        'contact' => [
            'mobile' => '0278122992',
            'landline' => '289993-44201',
            'email' => 'test@email.com',
            'url' => 'http://example.com',
        ],
        'contact_info' => 'INFO',
        'address' => [
            'number' => 243,
            'street' => 'Flowers Street',
            'postcode' => 344343,
            'coordinates' => [
                'latitude' => '46.95195',
                'longitude' => '-23.17107',
            ],
        ],
        'address_country_id' => $country->id,
        'name' => 'Company LTD',
        'tax_id' => 378273823,
        'registration_number' => 7382378732,
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
    ];

    $dataset2 = [
        'contact' => [
            'mobile' => '0278122993',
            'landline' => '289993-44202',
            'email' => 'test@email.com',
            'url' => 'http://examples.com',
        ],
        'contact_info' => 'INFO',
        'address' => [
            'number' => 70,
            'street' => 'SunFlowers Street',
            'postcode' => 344344,
            'coordinates' => [
                'latitude' => '46.95195',
                'longitude' => '-23.17107',
            ],
        ],
        'address_country_id' => $country->id,
        'name' => 'Distributor LTD',
        'tax_id' => 378273824,
        'registration_number' => 7382378735,
        'tax_value' => 20,
        'invoice_prefix' => 'INVS',
    ];

    $action = new CompanyStoreAction($user);
    $action->handle($dataset);
    $action->handle($dataset2);

    $company2 = Company::with([
        'addresses',
        'contacts',
    ])->whereName('Distributor LTD')->first();

    expect($company2)->toMatchArray([
        'name' => 'Distributor LTD',
    ]);
    expect($company2->addresses)->toHaveCount(1);
    expect($company2->contacts)->toHaveCount(1);

    $addresses = Address::all();
    expect($addresses)->toHaveCount(1);

    $contacts = Contact::all();
    expect($contacts)->toHaveCount(1);
});

test('company address/contact should be created and linked to each company', function () {
    $user = User::factory()->create([
        'name' => 'Manager User',
    ]);
    $country = Country::factory()->create();

    $dataset = [
        'contact' => [
            'mobile' => '0278122992',
            'landline' => '289993-44201',
            'email' => 'test@email.com',
            'url' => 'http://example.com',
        ],
        'contact_info' => 'INFO',
        'address' => [
            'number' => 243,
            'street' => 'Flowers Street',
            'postcode' => 344343,
            'coordinates' => [
                'latitude' => '46.95195',
                'longitude' => '-23.17107',
            ],
        ],
        'address_country_id' => $country->id,
        'name' => 'Company LTD',
        'tax_id' => 378273823,
        'registration_number' => 7382378732,
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
    ];

    $dataset2 = [
        'contact' => [
            'mobile' => '0278122993',
            'landline' => '289993-44202',
            'email' => 'testing@email.com',
            'url' => 'http://examples.com',
        ],
        'contact_info' => 'INFO',
        'address' => [
            'number' => 70,
            'street' => 'SunFlowers Street',
            'postcode' => 344344,
            'coordinates' => [
                'latitude' => '46.95196',
                'longitude' => '-23.17108',
            ],
        ],
        'address_country_id' => $country->id,
        'name' => 'Distributor LTD',
        'tax_id' => 378273824,
        'registration_number' => 7382378735,
        'tax_value' => 20,
        'invoice_prefix' => 'INVS',
    ];

    $action = new CompanyStoreAction($user);
    $action->handle($dataset);
    $action->handle($dataset2);

    $company = Company::with([
        'addresses',
        'contacts',
    ])->whereName('Company LTD')->first();

    expect($company)->toMatchArray([
        'name' => 'Company LTD',
    ]);
    expect($company->addresses)->toHaveCount(1);
    expect($company->contacts)->toHaveCount(1);

    $company2 = Company::with([
        'addresses',
        'contacts',
    ])->whereName('Distributor LTD')->first();

    expect($company2)->toMatchArray([
        'name' => 'Distributor LTD',
    ]);
    expect($company2->addresses)->toHaveCount(1);
    expect($company2->contacts)->toHaveCount(1);

    $addresses = Address::all();
    expect($addresses)->toHaveCount(2);

    $contacts = Contact::all();
    expect($contacts)->toHaveCount(2);
});

<?php

declare(strict_types=1);

use App\Actions\CompanyStoreAction;
use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->country = Country::factory()->create();
    $this->file = UploadedFile::fake()->image('avatar.jpg');

    $this->action = new CompanyStoreAction($this->administrator);
    actingAs($this->administrator);

    $this->contact1 = [
        'mobile' => '+19792815648',
        'landline' => '+1.276.336.3098',
        'email' => 'kuphal.thora@example.net',
        'url' => 'http://harvey.com/quidem-ea-velit-laborum',
        'info' => 'Quasi ut.',
    ];
    $this->contact2 = [
        'mobile' => '+19792815648',
        'landline' => '+1.276.336.3098',
        'email' => 'rashad.thora@example.net',
        'url' => 'http://harvey.com/quidem-ea-velit-laborum',
        'info' => 'Quasi ut.',
    ];

    $this->address1 = [
        'street_number' => '76274',
        'street' => 'Buster Harbors',
        'postcode' => '51040-6389',
        'building' => '72760',
        'floor' => '857',
        'unit' => '36012',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ],
    ];
    $this->address2 = [
        'street_number' => '7054',
        'street' => 'Green Pike',
        'postcode' => '56657',
        'building' => '2213',
        'floor' => '30284',
        'unit' => '6985',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784754,
            'longitude' => 46.4378747,
        ],
    ];
});

test('should create, link & attach address & contact to company', function () {
    $company = $this->action->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
        'address' => $this->address1,
        'contact' => $this->contact1,
    ]);

    expect($company)->toBeInstanceOf(Company::class);
    expect($company->addresses)->toHaveCount(1);
    expect($company->contacts)->toHaveCount(1);
    expect($company->created_by)->toEqual($this->administrator->id);
    expect($company->updated_by)->toEqual($this->administrator->id);
    expect($this->administrator->companies()->get())->toHaveCount(1);
});

test('should link contact & address for 2 companies', function () {
    $this->action->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
        'contact' => $this->contact1,
        'address' => $this->address1,
    ]);

    $this->action->handle([
        'name' => 'Company Testing',
        'tax_id' => '787423846',
        'registration_number' => '8472873443',
        'tax_value' => 30,
        'invoice_prefix' => 'INVS',
        'image' => $this->file,
        'contact' => $this->contact2,
        'address' => $this->address2,
    ]);

    $addresses = Address::all();
    $contacts = Contact::all();
    $companies = Company::all();
    expect($companies)->toHaveCount(2);
    expect($addresses)->toHaveCount(2);
    expect($contacts)->toHaveCount(2);
    expect($this->administrator->companies)->toHaveCount(2);
});

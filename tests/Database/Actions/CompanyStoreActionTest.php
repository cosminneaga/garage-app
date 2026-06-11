<?php

use App\Actions\CompanyStoreAction;
use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->admin->assignRole(UserRole::USER_ADMIN->value);

    $this->country = Country::factory()->create();
    $this->file = UploadedFile::fake()->image('avatar.jpg');

    $this->adminAction = new CompanyStoreAction($this->admin);

    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create([
        'country_id' => $this->country,
    ]);
});

test('should create, link & attach address & contact to company', function () {
    $this->adminAction->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
        'address' => [
            'number' => 123,
            'street' => 'Sunflower Street',
            'postcode' => 'B546BN',
            'extra' => 'Extra Information',
            'country_id' => $this->country->id,
            'coordinates' => [
                'latitude' => 9.4784783,
                'longitude' => 34.4378747,
            ]
        ],
        'contact' => [
            'mobile' => '0772993822',
            'landline' => '0112737728',
            'email' => 'contact@garage.com',
            'url' => 'http://example.com',
            'info' => 'Information'
        ],
    ]);

    $company = Company::where('name', 'Company Test')->first();
    expect($company)->toBeInstanceOf(Company::class);
    expect($company->addresses)->toHaveCount(1);
    expect($company->contacts)->toHaveCount(1);
    expect($this->admin->companies()->get())->toHaveCount(1);
});

test('should create & link company', function () {
    $this->adminAction->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
        'contact' => collect($this->contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'address' => collect($this->address)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ]);

    expect($this->admin->companies)->toHaveCount(1);
});

test('should link same contact & address, even if companies are not linked to the same user', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_ADMIN->value);

    $this->adminAction->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
        'contact' => collect($this->contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'address' => collect($this->address)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ]);

    $action = new CompanyStoreAction($user);
    $action->handle([
        'name' => 'Company Testing',
        'tax_id' => '787423846',
        'registration_number' => '8472873443',
        'tax_value' => 30,
        'invoice_prefix' => 'INVS',
        'image' => $this->file,
        'contact' => collect($this->contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'address' => collect($this->address)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ]);

    $addresses = Address::all();
    $contacts = Contact::all();
    $companies = Company::all();
    expect($this->admin->companies)->toHaveCount(1);
    expect($companies)->toHaveCount(2);
    expect($addresses)->toHaveCount(1);
    expect($contacts)->toHaveCount(1);
});

test('should link same contact & address, even if companies are linked to the same user', function () {
    $this->adminAction->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
        'contact' => collect($this->contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'address' => collect($this->address)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ]);

    $this->adminAction->handle([
        'name' => 'Company Testing',
        'tax_id' => '787423846',
        'registration_number' => '8472873443',
        'tax_value' => 30,
        'invoice_prefix' => 'INVS',
        'image' => $this->file,
        'contact' => collect($this->contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'address' => collect($this->address)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ]);

    $addresses = Address::all();
    $contacts = Contact::all();
    $companies = Company::all();
    expect($this->admin->companies)->toHaveCount(2);
    expect($companies)->toHaveCount(2);
    expect($addresses)->toHaveCount(1);
    expect($contacts)->toHaveCount(1);
});

test('should link different contact & address, even if companies are linked to the same user', function () {
    $this->adminAction->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
        'contact' => collect($this->contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'address' => collect($this->address)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ]);

    $contact = Contact::factory()->create();
    $address = Address::factory()->create([
        'country_id' => $this->country,
    ]);

    $this->adminAction->handle([
        'name' => 'Company Testing',
        'tax_id' => '787423846',
        'registration_number' => '8472873443',
        'tax_value' => 30,
        'invoice_prefix' => 'INVS',
        'image' => $this->file,
        'contact' => collect($contact)->except(['id', 'created_at', 'updated_at'])->toArray(),
        'address' => collect($address)->except(['id', 'created_at', 'updated_at'])->toArray(),
    ]);

    $addresses = Address::all();
    $contacts = Contact::all();
    $companies = Company::all();
    expect($this->admin->companies)->toHaveCount(2);
    expect($companies)->toHaveCount(2);
    expect($addresses)->toHaveCount(2);
    expect($contacts)->toHaveCount(2);
});

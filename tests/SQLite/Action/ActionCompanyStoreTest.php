<?php

declare(strict_types=1);

use App\Actions\CompanyStoreAction;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->country = Country::factory()->create();
});

test('handle: create a company & link to authenticated user', function () {
    actingAs($this->administrator);
    $company = App::make(CompanyStoreAction::class)->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => UploadedFile::fake()->image('avatar.jpg'),
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
    ]);

    expect($company)->toBeInstanceOf(Company::class);
    expect($company->addresses)->toHaveCount(1);
    expect($company->contacts)->toHaveCount(1);
    expect($company->created_by)->toEqual($this->administrator->id);
    expect($company->updated_by)->toEqual($this->administrator->id);
    expect($this->administrator->companies()->get())->toHaveCount(1);
});

test('handle: throw error when contact/address are missing', function () {
    actingAs($this->administrator);

    expect(fn () => App::make(CompanyStoreAction::class)->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
    ]))->toThrow('Address & Contact are required when Company data is stored');
});

<?php

declare(strict_types=1);

use App\Actions\CompanyUpdateAction;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->admin->assignRole(UserRole::USER_ADMIN->value);

    $this->country = Country::factory()->create();
    $this->file = UploadedFile::fake()->image('avatar.jpg');

    $this->adminAction = new CompanyUpdateAction($this->admin);

    $this->company = Company::factory()->create([
        'name' => 'Company Intialisation'
    ]);
});

test('should update company', function () {
    $this->adminAction->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
    ], $this->company);

    $company = Company::find($this->company->id);
    expect($company)->toBeInstanceOf(Company::class);
    expect($company->name)->toEqual('Company Test');
});

<?php

declare(strict_types=1);

use App\Actions\CompanyUpdateAction;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->country = Country::factory()->create();
    $this->file = UploadedFile::fake()->image('avatar.jpg');

    $this->action = new CompanyUpdateAction();

    $this->company = Company::factory()->create([
        'name' => 'Company Intialisation',
    ]);
});

test('should update company', function () {
    $this->action->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image' => $this->file,
    ], $this->company);

    expect($this->company)->toMatchArray([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 20,
        'invoice_prefix' => 'INV',
        'image_path' => 'companies/' . $this->file->hashName(),
    ]);
});

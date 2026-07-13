<?php

declare(strict_types=1);

use App\Actions\CompanyUpdateAction;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    $this->country = Country::factory()->create();
    $file = UploadedFile::fake()->image('avatar.jpg');
    $this->company = Company::factory()->create([
        'name' => 'Company Init',
        'tax_id' => '12345',
        'registration_number' => '12345',
        'tax_value' => 20,
        'invoice_prefix' => 'INV-INIT',
        'image_path' => 'companies/' . $file->hashName(),
    ]);
});

test('handle: update company details', function () {
    $file = UploadedFile::fake()->image('avatars.jpg');
    App::make(CompanyUpdateAction::class)->handle([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 30,
        'invoice_prefix' => 'INV',
        'image' => $file,
    ], $this->company);

    expect($this->company)->toMatchArray([
        'name' => 'Company Test',
        'tax_id' => '787423847',
        'registration_number' => '8472873442',
        'tax_value' => 30,
        'invoice_prefix' => 'INV',
        'image_path' => 'companies/' . $file->hashName(),
    ]);
});

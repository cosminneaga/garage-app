<?php

use App\Actions\ModelContactStoreAction;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\App;

test('handle: store contact for an user', function () {
    $user = User::factory()->create();

    App::make(ModelContactStoreAction::class)->handle([
        'mobile' => '316-599-5131',
        'landline' => '781.446.9941',
        'email' => 'test@garage.com',
        'url' => 'http://example.com',
    ], $user);

    expect($user->contacts)->toHaveCount(1);
});

test('handle: store contact for a company', function () {
    $company = Company::factory()->create();

    App::make(ModelContactStoreAction::class)->handle([
        'mobile' => '316-599-5131',
        'landline' => '781.446.9941',
        'email' => 'test@garage.com',
        'url' => 'http://example.com',
    ], $company);

    expect($company->contacts)->toHaveCount(1);
});

test('handle: store contact for a supplier', function () {
    $supplier = Supplier::factory()->create();

    App::make(ModelContactStoreAction::class)->handle([
        'mobile' => '316-599-5131',
        'landline' => '781.446.9941',
        'email' => 'test@garage.com',
        'url' => 'http://example.com',
    ], $supplier);

    expect($supplier->contacts)->toHaveCount(1);
});

test('handle: throw an error is contact with same email has been found', function () {
    $user = User::factory()->create();
    Contact::factory()->create([
        'email' => 'test@garage.com',
    ]);

    expect(fn () => App::make(ModelContactStoreAction::class)->handle([
        'mobile' => '316-599-5131',
        'landline' => '781.446.9941',
        'email' => 'test@garage.com',
        'url' => 'http://example.com',
    ], $user))->toThrow('Contact information already exists under same email');
});

<?php

declare(strict_types=1);

use App\Actions\ModelContactStoreAction;
use App\Models\Company;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();

    $this->country = Country::factory()->create();
    $this->action = new ModelContactStoreAction();
});

test('should store contact for user', function () {
    $this->action->handle([
        'mobile' => '0772993822',
        'landline' => '0112737728',
        'email' => 'contact@garage.com',
        'url' => 'http://example.com',
        'info' => 'Information',
    ], $this->user);

    expect($this->user->contacts)->toHaveCount(1);
});

test('should store contact for company', function () {
    $this->action->handle([
        'mobile' => '0772993822',
        'landline' => '0112737728',
        'email' => 'contact@garage.com',
        'url' => 'http://example.com',
        'info' => 'Information',
    ], $this->company);

    expect($this->company->contacts)->toHaveCount(1);
});

test('should store contact for supplier', function () {
    $this->action->handle([
        'mobile' => '0772993822',
        'landline' => '0112737728',
        'email' => 'contact@garage.com',
        'url' => 'http://example.com',
        'info' => 'Information',
    ], $this->supplier);

    expect($this->supplier->contacts)->toHaveCount(1);
});

test('should not create a new resource if exists', function () {
    $this->action->handle([
        'mobile' => '0772993822',
        'landline' => '0112737728',
        'email' => 'contact@garage.com',
        'url' => 'http://example.com',
        'info' => 'Information',
    ], $this->user);

    expect(fn () => $this->action->handle([
        'mobile' => '0772993823',
        'landline' => '0112737729',
        'email' => 'contact@garage.com',
        'url' => 'http://example2.com',
        'info' => 'Information',
    ], $this->company))->toThrow('Contact information already exists under same email.');
});

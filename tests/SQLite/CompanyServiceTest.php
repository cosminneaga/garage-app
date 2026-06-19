<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use App\Services\CompanyService;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR->value);

    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER->value);
    $this->administrator->managers()->attach($this->manager);
});

test('filter own companies', function () {
    $service = new CompanyService($this->administrator);
    $companies = Company::factory(5)->create();
    $this->administrator->companies()->attach($companies);

    Company::factory(10)->create();

    expect($service->model()->resourceFilterOwn()->get())->toHaveCount(5);
});

test('filter own removed, not-removed, and all companies', function () {
    $service = new CompanyService($this->administrator);
    $companies = Company::factory(5)->create();
    $this->administrator->companies()->attach($companies);

    $companies[0]->delete();

    expect($service->model()->resourceFilterOwn()->get())->toHaveCount(4);
    expect($service->model()->resourceFilterOwn(ResourceFilter::ONLY_TRASHED)->get())->toHaveCount(1);
    expect($service->model()->resourceFilterOwn(ResourceFilter::WITH_TRASHED)->get())->toHaveCount(5);
});

test('search through own companies', function () {
    $service = new CompanyService($this->administrator);
    $companies = Company::factory()->createMany([
        ['name' => 'one'],
        ['name' => 'two'],
        ['name' => 'three'],
        ['name' => 'four'],
        ['name' => 'five'],
    ]);
    $this->administrator->companies()->attach($companies);

    Company::factory()->createMany([
        ['name' => 'toronto ltc'],
        ['name' => 'one company for your needs']
    ]);
    $companies[0]->delete();

    expect($service->search('one')->resourceFilterOwn()->get())->toHaveCount(0);
    expect($service->search('t')->resourceFilterOwn()->get())->toHaveCount(2);
});

test('resourceFilter vs resourceFilterOwn', function () {
    $service = new CompanyService($this->administrator);
    $companies = Company::factory()->createMany([
        ['name' => 'one'],
        ['name' => 'two'],
        ['name' => 'three'],
        ['name' => 'four'],
        ['name' => 'five'],
    ]);

    $companies[0]->delete();

    expect($service->model()->resourceFilter()->get())->toHaveCount(4);
    expect($service->model()->resourceFilter(ResourceFilter::ONLY_TRASHED)->get())->toHaveCount(1);
    expect($service->model()->resourceFilter(ResourceFilter::WITH_TRASHED)->get())->toHaveCount(5);
    expect($service->model()->resourceFilterOwn()->get())->toHaveCount(0);
    expect($service->model()->resourceFilterOwn(ResourceFilter::ONLY_TRASHED)->get())->toHaveCount(0);
    expect($service->model()->resourceFilterOwn(ResourceFilter::WITH_TRASHED)->get())->toHaveCount(0);
});

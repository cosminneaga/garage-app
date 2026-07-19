<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->company = Company::factory()->create();
});

test('administrator: fetch companies', function () {
    $administrator = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $administrator->companies()->attach($this->company);
    actingAs($administrator);

    get(route('companies.index'))
        ->assertStatus(200)
        ->assertSee($this->company->name);
});

test('manager: fetch companies', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::MANAGER);
    $manager->companies()->attach($this->company);
    actingAs($manager);

    get(route('companies.index'))
        ->assertStatus(200)
        ->assertSee($this->company->name);
});

test('user: fetch companies', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $user->companies()->attach($this->company);
    actingAs($user);

    get(route('companies.index'))
        ->assertStatus(200)
        ->assertSee($this->company->name);
});

test('user: should not see companies that are not attached', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $user->companies()->attach($this->company);
    $company = Company::factory()->create();
    actingAs($user);

    get(route('companies.index'))
        ->assertStatus(200)
        ->assertSee($this->company->name)
        ->assertDontSee($company->name);
});

test('user: filter companies', function () {
    $companies = Company::factory()->createMany([
        ['name' => 'One'],
        ['name' => 'Two'],
    ]);
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $user->companies()->attach($companies);
    actingAs($user);

    get(route('companies.index', ['search' => 'One']))
        ->assertStatus(200)
        ->assertSee('One')
        ->assertDontSee('Two');
});

test('no auth: should not see company if not authenticated', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $user->companies()->attach($this->company);

    get(route('companies.index'))
        ->assertStatus(302)
        ->assertDontSee($this->company->name)
        ->assertRedirectToRoute('login');
});

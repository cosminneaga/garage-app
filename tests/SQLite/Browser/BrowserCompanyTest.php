<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->companies = Company::factory()->createMany([
        ['name' => 'Company One'],
        ['name' => 'Company Two'],
    ]);
    $this->administrator->companies()->attach($this->companies);
});

test('administrator: should see only own companies listing table', function () {
    actingAs($this->administrator);

    Company::factory()->createMany([
        ['name' => 'Company External'],
    ]);

    visit(route('companies.index'))
        ->assertSee('Company One')
        ->assertSee('Company Two')
        ->assertDontSee('Company External');
});

test('administrator: should filter search', function () {
    actingAs($this->administrator);

    visit(route('companies.index', ['search' => 'Company One']))
        ->assertSee('Company One')
        ->assertDontSee('Company Two');
});

test('administrator: should remove company', function () {
    actingAs($this->administrator);

    visit(route('companies.index'))
        ->assertSee('Company One')
        ->assertSee('Company Two')
        ->click('@company-delete-' . $this->companies[0]->id . '-modal-trigger')
        ->click('@company-delete-' . $this->companies[0]->id . '-modal-confirm')
        ->assertDontSee('Company One');
});

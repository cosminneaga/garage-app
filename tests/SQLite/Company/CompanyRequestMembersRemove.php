<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->administrator = User::factory()->create();
    $this->manager = User::factory()->create();
    $this->user = User::factory()->create();

    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->manager->assignRole(UserRole::MANAGER);
    $this->user->assignRole(UserRole::USER);

    $this->company->users()->attach($this->administrator);
});

test('administrator: remove manager', function () {
    $this->administrator->managers()->attach($this->manager);
    $this->company->users()->attach($this->manager);
    actingAs($this->administrator);

    delete(route('companies.user.destroy', [$this->company, $this->manager]))
        ->assertRedirect()
        ->assertSessionHas('message', (object) [
            'type' => 'warning',
            'title' => 'User unlinked',
            'message' => 'User has been unlinked from company',
        ]);
});

test('administrator [detached]: cannot remove manager', function () {
    $this->company->users()->detach($this->administrator);
    $this->administrator->managers()->attach($this->manager);
    $this->company->users()->attach($this->manager);
    actingAs($this->administrator);

    delete(route('companies.user.destroy', [$this->company, $this->manager]))
        ->assertUnauthorized();
});

test('administrator: cannot remove attached users', function () {
    $this->administrator->users()->attach($this->user);
    $this->company->users()->attach($this->user);
    actingAs($this->administrator);

    delete(route('companies.user.destroy', [$this->company, $this->user]))
        ->assertForbidden();
});

test('administrator: cannot remove not linked manager', function () {
    $this->administrator->managers()->attach($this->manager);
    actingAs($this->administrator);

    delete(route('companies.user.destroy', [$this->company, $this->manager]))
        ->assertNotFound();
});

test('manager: remove user', function () {
    $this->manager->users()->attach($this->user);
    $this->company->users()->attach([$this->manager, $this->user]);
    actingAs($this->manager);

    delete(route('companies.user.destroy', [$this->company, $this->user]))
        ->assertRedirect()
        ->assertSessionHas('message', (object) [
            'type' => 'warning',
            'title' => 'User unlinked',
            'message' => 'User has been unlinked from company',
        ]);
});

test('manager [detached]: cannot remove user', function () {
    $this->company->users()->detach($this->manager);
    $this->manager->users()->attach($this->user);
    $this->company->users()->attach($this->user);
    actingAs($this->manager);

    delete(route('companies.user.destroy', [$this->company, $this->user]))
        ->assertUnauthorized();
});

test('manager: cannot remove unauthorized/unexisting users', function () {
    $this->manager->users()->attach($this->user);
    $this->company->users()->attach([$this->administrator, $this->manager]);
    actingAs($this->manager);

    delete(route('companies.user.destroy', [$this->company, $this->user]))
        ->assertNotFound();
    delete(route('companies.user.destroy', [$this->company, $this->administrator]))
        ->assertForbidden();
});

test('user: cannot remove any members', function () {
    $user = User::factory()->create();
    $this->company->users()->attach([$this->user, $user, $this->administrator, $this->manager]);
    actingAs($this->user);

    delete(route('companies.user.destroy', [$this->company, $user]))
        ->assertForbidden();
    delete(route('companies.user.destroy', [$this->company, $this->manager]))
        ->assertForbidden();
    delete(route('companies.user.destroy', [$this->company, $this->administrator]))
        ->assertForbidden();
});

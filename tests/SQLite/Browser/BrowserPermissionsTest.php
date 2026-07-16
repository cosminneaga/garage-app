<?php

use App\Enums\UserRole;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);
    $this->administrator->managers()->attach($this->manager);
});

test('administrator: assign/revoke manager permission', function () {
    actingAs($this->administrator);

    visit(route('managers.edit', $this->manager))
        ->click('@permissions')
        ->assertDontSee('Revoke')
        ->click('@company-store-assign')
        ->assertSee('Permission assigned')
        ->assertSee('Permission assigned to user ' . $this->manager->name)
        ->assertSee('Revoke')
        ->click('@company-store-revoke')
        ->assertSee('Permission revoked')
        ->assertSee('Permission revoked from user ' . $this->manager->name)
        ->assertDontSee('Revoke');
});

<?php

use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->managers = User::factory()->createMany([
        ['name' => 'Manager One'],
        ['name' => 'Manager Two'],
    ]);
    $role = Role::findByName(UserRole::MANAGER->value);
    $role->users()->attach($this->managers);
    $this->administrator->managers()->attach($this->managers);
});

test('administrator: should only see table of attached managers', function () {
    actingAs($this->administrator);

    $user = User::factory()->create();

    visit(route('managers.index'))
        ->assertSee('Manager One')
        ->assertSee('Manager Two')
        ->assertDontSee($user->name);
});

test('administrator: should filter search', function () {
    actingAs($this->administrator);

    visit(route('managers.index'))
        ->fill('@user_search', 'Manager One')
        ->click('@user_search_submit')
        ->assertSee('Manager One')
        ->assertDontSee('Manager Two');
});

test('administrator: should go on manager\'s edit page', function () {
    actingAs($this->administrator);
    $manager = $this->managers->first();

    visit(route('managers.index'))
        ->click('@user-' . $manager->id . '-edit-button')
        ->assertRoute('managers.edit', [$manager->id]);
});

test('administrator: should remove manager', function () {
    actingAs($this->administrator);
    $manager = $this->managers->first();

    visit(route('managers.index'))
        ->click('@user-delete-' . $manager->id . '-modal-trigger')
        ->click('@user-delete-' . $manager->id . '-modal-confirm')
        ->assertSee('Manager removed')
        ->assertSee('The manager ' . $manager->name . ' has been successfully removed from the team')
        ->assertDontSee($manager->name);
});

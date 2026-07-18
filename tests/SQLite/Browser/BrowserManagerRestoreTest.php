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
    $this->manager->delete();
});

test('administrator: should restore removed manager', function () {
    actingAs($this->administrator);

    visit(route('managers.removed'))
        ->assertSee($this->manager->name)
        ->click('@user-restore-' . $this->manager->id . '-modal-trigger')
        ->click('@user-restore-' . $this->manager->id . '-modal-confirm')
        ->assertSee('Manager restored')
        ->assertSee('The manager has been successfully restored and is now active again')
        ->assertDontSee($this->manager->name);
});

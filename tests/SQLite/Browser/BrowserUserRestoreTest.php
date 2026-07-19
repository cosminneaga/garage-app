<?php

use App\Enums\UserRole;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);

    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::USER);
    $this->manager->users()->attach($this->user);
    $this->user->delete();
});

test('administrator: should restore removed manager', function () {
    actingAs($this->manager);

    visit(route('users.removed'))
        ->assertSee($this->user->name)
        ->click('@user-restore-' . $this->user->id . '-modal-trigger')
        ->click('@user-restore-' . $this->user->id . '-modal-confirm')
        ->assertSee('User restored')
        ->assertSee('The user has been successfully restored and is now active again')
        ->assertDontSee($this->user->name);
});

<?php

use App\Enums\UserRole;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::USER);
});

test('update it\'s own profile', function () {
    actingAs($this->user);

    put(route('profile.users.update'), [
        'name' => 'Updated Name',
        'email' => 'updated.user@garage.com',
        'active' => 'false',
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Profile updated',
            'message' => 'Your profile has been updated successfully',
        ]);
});

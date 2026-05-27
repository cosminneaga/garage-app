<?php

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->password = 'P@ssword';
    $this->super = User::factory()->create([
        'name' => 'Testing Super User',
        'email' => 'testing_super@garage.com',
        'password' => $this->password,
    ]);
    $this->super->assignRole(UserRole::SUPER->value);
    $this->country = Country::factory()->create();

    $this->users = User::factory()->createMany([
        ['name' => 'User1'],
        ['name' => 'User2'],
        ['name' => 'User3']
    ]);
    $this->super->team()->attach($this->users);
});

it('should see team members in team table', function () {
    actingAs($this->super);

    visit(route('users.index'))
        ->assertSee('User1')
        ->assertSee('User2')
        ->assertSee('User3');
});

it('should see team members in team table & removed table', function () {
    actingAs($this->super);

    $this->removedUser = $this->super->team()->where('name', 'User3')->first();

    visit(route('users.index'))
        ->assertSee('User1')
        ->assertSee('User2')
        ->assertSee('User3')
        ->click('@user-delete-button-' . $this->removedUser->id)
        ->click('@user-delete-confirm-modal-' . $this->removedUser->id)
        ->assertSee('User1')
        ->assertSee('User2');

    visit(route('users.removed'))
        ->assertSee('User3');
});

it('should see team members in team table & removed table & restore removed user', function () {
    actingAs($this->super);

    $user = $this->super->team()->where('name', 'User3')->first();

    visit(route('users.index'))
        ->assertSee('User1')
        ->assertSee('User2')
        ->assertSee('User3')
        ->click('@user-delete-button-' . $user->id)
        ->click('@user-delete-confirm-modal-' . $user->id)
        ->assertSee('User1')
        ->assertSee('User2');

    visit(route('users.removed'))
        ->assertSee('User3')
        ->click('@user-restore-button-' . $user->id)
        ->click('@user-restore-confirm-modal-' . $user->id)
        ->assertDontSee('User3');

    visit(route('users.index'))
        ->assertSee('User1')
        ->assertSee('User2')
        ->assertSee('User3');
});

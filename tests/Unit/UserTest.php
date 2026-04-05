<?php

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Spatie\Permission\Exceptions\UnauthorizedException;

beforeEach(function () {
    $this->seed(PermissionsSeeder::class);
});

test('should access team members when role is assigned', function () {
    $members = User::factory()->create([
        'name' => 'Mary Doe',
    ]);

    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);
    $manager->team()->attach($members);

    $response = $this->actingAs($manager)->get(route('users.index'));
    $response->assertStatus(200)
        ->assertViewHas('users')
        ->assertSee('Mary Doe');
});

test('should not access team member if role is detached', function () {
    $members = User::factory()->create([
        'name' => 'John Doe',
    ]);

    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);
    $manager->team()->attach($members);
    $manager->removeRole(UserRole::USER_ADMIN->value);

    $response = $this->actingAs($manager)->get(route('users.index'));
    $response->assertStatus(403);
});

test('should not access team member if role is administrator', function () {
    $members = User::factory()->create([
        'name' => 'John Doe',
    ]);

    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);
    $manager->team()->attach($members);
    $manager->removeRole(UserRole::USER_ADMIN->value);
    $manager->assignRole(UserRole::USER_EDITOR->value);

    $response = $this->actingAs($manager)->get(route('users.index'));
    $response->assertStatus(403);
});

test('should not attach users without having the role defined', function () {
    $members = User::factory()->create();

    $manager = User::factory()->create();
    $this->expectException(UnauthorizedException::class);
    $manager->team()->attach($members);
});

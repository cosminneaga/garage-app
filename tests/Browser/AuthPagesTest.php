<?php

use App\Enums\UserRole;
use App\Models\User;

it('should welcome the user', function () {
    visit(route('home'))
        ->assertSee('Hello, Guest!');
});

it('should refuse login when user is not created', function () {
    visit(route('login'))
        ->fill('email', 'manager@garage.com')
        ->fill('password', 'P@ssword')
        ->click('@login-button')
        ->assertSee('Authentication failed')
        ->assertSee('We were unable to authenticate using the provided credentials. Please verify your login details and try again.');
});

it('should login created user', function () {
    $password = 'P@ssword';
    $user = User::factory()->create([
        'email' => 'testing@garage.com',
        'password' => $password,
    ]);
    $user->assignRole(UserRole::USER_ADMIN);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', $password)
        ->click('@login-button')
        ->assertSee($user->name)
        ->assertRoute('home');
});

it('should not login wrong password', function () {
    $password = 'P@ssword';
    $user = User::factory()->create([
        'email' => 'testing@garage.com',
        'password' => $password,
    ]);
    $user->assignRole(UserRole::USER_ADMIN);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', $password . 's')
        ->click('@login-button')
        ->assertSee('Authentication failed')
        ->assertSee('We were unable to authenticate using the provided credentials. Please verify your login details and try again.');
});

it('should not login wrong email', function () {
    $password = 'P@ssword';
    $user = User::factory()->create([
        'email' => 'testing@garage.com',
        'password' => $password,
    ]);
    $user->assignRole(UserRole::USER_ADMIN);

    visit('/login')
        ->fill('email', 'test@garage.com')
        ->fill('password', $password)
        ->click('@login-button')
        ->assertSee('Authentication failed')
        ->assertSee('We were unable to authenticate using the provided credentials. Please verify your login details and try again.');
});

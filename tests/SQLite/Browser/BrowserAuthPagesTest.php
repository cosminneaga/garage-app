<?php

use App\Enums\UserRole;
use App\Models\User;

beforeEach(function () {
    $this->password = 'P@ssword';
    $this->administrator = User::factory()->create([
        'email' => 'testing@garage.com',
        'password' => $this->password,
    ]);
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
});

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

it('administrator: should login', function () {
    visit('/login')
        ->fill('email', $this->administrator->email)
        ->fill('password', $this->password)
        ->click('@login-button')
        ->assertSee($this->administrator->name)
        ->assertRoute('home');
});

it('administrator: should not login wrong password', function () {
    visit('/login')
        ->fill('email', $this->administrator->email)
        ->fill('password', $this->password . 's')
        ->click('@login-button')
        ->assertSee('Authentication failed')
        ->assertSee('We were unable to authenticate using the provided credentials. Please verify your login details and try again.');
});

it('administrator: should not login wrong email', function () {
    visit('/login')
        ->fill('email', 'test@garage.com')
        ->fill('password', $this->password)
        ->click('@login-button')
        ->assertSee('Authentication failed')
        ->assertSee('We were unable to authenticate using the provided credentials. Please verify your login details and try again.');
});

<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->manager = User::factory()->create();
    $this->user = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->manager->assignRole(UserRole::MANAGER);
    $this->user->assignRole(UserRole::USER);

    $this->administrator->memberAttach($this->manager);
    $this->manager->memberAttach($this->user);

    $this->country = Country::factory()->create();
});

test('route can only be accessed by administrator', function () {
    actingAs($this->administrator);
    get(route('managers.index'))
        ->assertSee($this->manager->name);

    actingAs($this->manager);
    get(route('managers.index'))
        ->assertForbidden();

    actingAs($this->user);
    get(route('managers.index'))
        ->assertForbidden();
});

test('create', function () {
    actingAs($this->administrator);

    post(route('managers.store'), [
        'name' => 'Manager',
        'email' => 'manager@garage.com',
        'password' => 'P@ssword',
        'password_confirmed' => 'P@ssword',
        'active' => 'true',
        'address' => [
            'street_number' => '76274',
            'street' => 'Buster Harbors',
            'postcode' => '51040-6389',
            'building' => '72760',
            'floor' => '857',
            'unit' => '36012',
            'country_id' => $this->country->id,
        ],
        'contact' => [
            'mobile' => '+19792815648',
            'landline' => '+1.276.336.3098',
            'email' => 'kuphal.thora@example.net',
            'url' => 'http://harvey.com/quidem-ea-velit-laborum',
            'info' => 'Quasi ut.',
        ],
    ])
        ->assertRedirectToRoute('managers.index')
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Manager created',
            'message' => 'The manager has been successfully created and added to the team',
        ]);
});

test('update', function () {
    actingAs($this->administrator);

    put(route('managers.update', $this->manager), [
        'name' => 'Manager',
        'email' => 'manager@garage.com',
        'password' => 'P@ssword',
        'password_confirmed' => 'P@ssword',
        'active' => 'false',
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Manager updated',
            'message' => 'The manager details have been successfully updated',
        ]);
});

test('restore', function () {
    actingAs($this->administrator);

    $this->manager->delete();

    post(route('managers.restore', $this->manager))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Manager restored',
            'message' => 'The manager has been successfully restored and is now active again',
        ]);
});

test('destroy', function () {
    actingAs($this->administrator);

    delete(route('managers.destroy', $this->manager))
        ->assertRedirectToRoute('managers.index')
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Manager removed',
            'message' => 'The manager ' . $this->manager->name . ' has been successfully removed from the team',
        ]);
});

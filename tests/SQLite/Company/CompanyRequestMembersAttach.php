<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Country;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->company = Company::factory()->create();
    $this->company->users()->attach($this->administrator);

    $this->country = Country::factory()->create();
});

test('administrator: create & attach manager', function () {
    actingAs($this->administrator);

    post(route('companies.user.store', $this->company), [
        'name' => 'user',
        'email' => 'user@garage.com',
        'password' => 'P@ssword',
        'password_confirmed' => 'P@ssword',
        'active' => 'true',
        'contact' => [
            'mobile' => '7276617267',
            'email' => 'user@garage.com',
        ],
        'address' => [
            'street_number' => '321',
            'street' => 'Flower Street',
            'postcode' => '31283781',
            'country_id' => $this->country->id,
            'coordinates' => null,
        ],
    ])
    ->assertRedirect()
    ->assertSessionHas('message', (object) [
        'type' => 'success',
        'title' => 'User created & linked',
        'message' => 'User has been created and linked to company',
    ]);

    # checking user role
    $user = User::where('name', 'user')->first();
    expect($user->getRoleNames())->toMatchArray([UserRole::MANAGER->value]);
});

test('manager: create & attach user', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::MANAGER);
    $this->company->users()->attach($manager);
    actingAs($manager);

    post(route('companies.user.store', $this->company), [
        'name' => 'user',
        'email' => 'user@garage.com',
        'password' => 'P@ssword',
        'password_confirmed' => 'P@ssword',
        'active' => 'true',
        'contact' => [
            'mobile' => '7276617267',
            'email' => 'user@garage.com',
        ],
        'address' => [
            'street_number' => '321',
            'street' => 'Flower Street',
            'postcode' => '31283781',
            'country_id' => $this->country->id,
            'coordinates' => null,
        ],
    ])
    ->assertRedirect()
    ->assertSessionHas('message', (object) [
        'type' => 'success',
        'title' => 'User created & linked',
        'message' => 'User has been created and linked to company',
    ]);

    # checking user role
    $user = User::where('name', 'user')->first();
    expect($user->getRoleNames())->toMatchArray([UserRole::USER->value]);
});

test('user: create & attach user, user should not be able to create & attach other users', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $this->company->users()->attach($user);
    actingAs($user);

    post(route('companies.user.store', $this->company), [
        'name' => 'user',
        'email' => 'user@garage.com',
        'password' => 'P@ssword',
        'password_confirmed' => 'P@ssword',
        'active' => 'true',
        'contact' => [
            'mobile' => '7276617267',
            'email' => 'user@garage.com',
        ],
        'address' => [
            'street_number' => '321',
            'street' => 'Flower Street',
            'postcode' => '31283781',
            'country_id' => $this->country->id,
            'coordinates' => null,
        ],
    ])
    ->assertForbidden();

    # checking user role
    $user = User::where('name', 'user')->first();
    expect($user)->toBeNull();
});

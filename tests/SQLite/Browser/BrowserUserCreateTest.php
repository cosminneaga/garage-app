<?php

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);
    $this->country = Country::factory()->create();
});

test('manager: create new user', function () {
    actingAs($this->manager);

    visit(route('users.create'))
        ->fill('@user_name', 'User')
        ->fill('@user_email', 'user@garage.com')
        ->fill('@user_password', 'P@ssword')
        ->fill('@user_password_confirmed', 'P@ssword')
        ->check('@user_active')
        ->fill('@user_address_street_number', '354')
        ->fill('@user_address_street', 'Flower Street')
        ->fill('@user_address_postcode', 'B328HDJ')
        ->select('@user_address_country_id', $this->country->id)
        ->fill('@user_contact_email', 'user@garage.com')
        ->fill('@user_contact_mobile', '8733-323-544')
        ->click('@user-create-submit')
        ->assertRoute('users.index')
        ->assertSee('User created')
        ->assertSee('The user has been successfully created and added to the team')
        ->assertSee('user@garage.com');
});

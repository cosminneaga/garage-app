<?php

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->country = Country::factory()->create();
});

test('administrator: create new manager', function () {
    actingAs($this->administrator);

    visit(route('managers.create'))
        ->fill('@manager_name', 'Manager')
        ->fill('@manager_email', 'manager@garage.com')
        ->fill('@manager_password', 'P@ssword')
        ->fill('@manager_password_confirmed', 'P@ssword')
        ->check('@manager_active')
        ->fill('@manager_address_street_number', '354')
        ->fill('@manager_address_street', 'Flower Street')
        ->fill('@manager_address_postcode', 'B328HDJ')
        ->select('@manager_address_country_id', $this->country->id)
        ->fill('@manager_contact_email', 'manager@garage.com')
        ->fill('@manager_contact_mobile', '8733-323-544')
        ->click('@manager-create-submit')
        ->assertRoute('managers.index')
        ->assertSee('Manager created')
        ->assertSee('The manager has been successfully created and added to the team')
        ->assertSee('manager@garage.com');
});

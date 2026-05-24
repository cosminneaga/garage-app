<?php

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;
use function Pest\Laravel\{actingAs};


beforeEach(function () {
    $this->password = 'P@ssword';
    $this->manager = User::factory()->create([
        'name' => 'Manager User',
        'email' => 'manager@garage.com',
        'password' => $this->password,
    ]);
    $this->manager->assignRole(UserRole::SUPER->value);

    $this->user = User::factory()->create([
        'name' => 'Created User',
        'email' => 'user@garage.com',
    ]);
    $this->manager->team()->attach($this->user);
});

// it('should login the manager', function () {
//     visit(route('login'))
//         ->fill('email', $this->manager->email)
//         ->fill('password', $this->password)
//         ->click('#login-btn')
//         ->assertSee('Hello, '.$this->manager->name.'!');

//     $this->assertAuthenticated();
// });

// it('should see users list', function () {
//     $this->actingAs($this->manager);
//     $this->assertAuthenticated();

//     visit(route('users.index', ['limit' => 10]))
//         ->assertTitleContains('Team')
//         ->assertSee('user@garage.com');
// });

it('should create a user using create form', function () {
    $country = Country::factory()->create();
    actingAs($this->manager);

    visit('/users/create')
        ->fill('@name', 'Editor User')
        ->fill('@email', 'editor@garage.com')
        ->fill('@password', 'P@ssword')
        ->fill('@password_confirmed', 'P@ssword')
        ->select('@role', 'user_viewer')
        // ->check('@active')

        ->fill('@address_number', '564')
        ->fill('@address_street', 'SunFlower Street')
        ->fill('@address_postcode', '893829')
        ->select('@address_country_id', $country->id)
        ->fill('@address_coordinates_latitude', '8.327832')
        ->fill('@address_coordinates_longitude', '94.676743')

        ->fill('@contact_mobile', '0788444666')
        ->fill('@contact_landline', '0112664773')
        ->fill('@contact_email', 'contact@garage.com')
        ->fill('@contact_url', 'https://garage.com')
        ->fill('@contact_info', 'Extra information about how to contact me')

        ->click('@form-users-create-submit');
});

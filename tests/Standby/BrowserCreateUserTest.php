<?php

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->password = 'P@ssword';
    $this->manager = User::factory()->create([
        'name' => 'Manager',
        'email' => 'manager@garage.com',
        'password' => $this->password,
    ]);
    $this->manager->assignRole(UserRole::MANAGER);
    $this->country = Country::factory()->create();
});

// !!! This tests does not attach created user to the manager, please check

it('successfully creates complete user details using create form', function () {

    // $file = UploadedFile::fake()->image('avatar.jpg');
    actingAs($this->manager);

    visit(route('users.create'))
        ->fill('@user_name', 'Testing User')
        ->fill('@user_email', 'testing_user@garage.com')

        // #TODO - only uncomment when php-pest-browser-plugin have been fixed the thing with multipart/form-data
        // https://github.com/pestphp/pest-plugin-browser/pull/200
        // ->attach('image', $file)

        ->fill('@user_password', 'TestingP@ssword')
        ->fill('@user_password_confirmed', 'TestingP@ssword')
        ->check('@user_active')
        ->fill('@user_address_street_number', '564')
        ->fill('@user_address_street', 'SunFlower Street')
        ->fill('@user_address_postcode', '893829')
        ->select('@user_address_country_id', $this->country->id)
        ->fill('@user_contact_mobile', '0788444666')
        ->fill('@user_contact_landline', '0112664773')
        ->fill('@user_contact_email', 'contact@garage.com')
        ->fill('@user_contact_url', 'https://garage.com')
        ->fill('@user_contact_info', 'Extra information about how to contact me')

        ->click('@form-users-create-submit')
        ->assertRoute('users.index');

    $user = User::where('email', 'testing_user@garage.com')->first();
    expect($user)->toBeInstanceOf(User::class);
});

it('successfully creates complete inactive user details using create form', function () {

    // $file = UploadedFile::fake()->image('avatar.jpg');
    actingAs($this->manager);

    visit(route('users.create'))
        ->fill('@user_name', 'Testing User')
        ->fill('@user_email', 'testing_user@garage.com')

        // #TODO - only uncomment when php-pest-browser-plugin have been fixed the thing with multipart/form-data
        // https://github.com/pestphp/pest-plugin-browser/pull/200
        // ->attach('image', $file)

        ->fill('@user_password', 'TestingP@ssword')
        ->fill('@user_password_confirmed', 'TestingP@ssword')

        ->fill('@user_address_street_number', '564')
        ->fill('@user_address_street', 'SunFlower Street')
        ->fill('@user_address_postcode', '893829')
        ->select('@user_address_country_id', $this->country->id)
        ->fill('@user_contact_mobile', '0788444666')
        ->fill('@user_contact_landline', '0112664773')
        ->fill('@user_contact_email', 'contact@garage.com')
        ->fill('@user_contact_url', 'https://garage.com')
        ->fill('@user_contact_info', 'Extra information about how to contact me')

        ->click('@form-users-create-submit')

        ->assertRoute('users.index');

    expect($this->manager->users()->get())->toHaveCount(1);
    expect($this->manager->users()->first()->active)->toBeFalse();
});

it('unsuccesfull create due to missing accurate information', function () {
    actingAs($this->manager);

    visit(route('users.create'))
        ->fill('@user_password', 'TestingP@ssword')
        ->fill('@user_password_confirmed', 'TestingP@sswords')

        ->click('@form-users-create-submit')

        ->assertSee('The name field is required')
        ->assertSee('The email field is required')
        ->assertSee('The password confirmed field must match password')
        ->assertSee('The address.street_number field is required')
        ->assertSee('The address.street field is required')
        ->assertSee('The address.postcode field is required')
        ->assertSee('The address.coordinates.latitude field is required')
        ->assertSee('The address.coordinates.longitude field is required')
        ->assertSee('The contact.mobile field is required')
        ->assertSee('The contact.email field is required')

        ->assertRoute('users.create');
});

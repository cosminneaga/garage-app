<?php

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;

// use Illuminate\Http\UploadedFile;

use function Pest\Laravel\{actingAs};

beforeEach(function () {
    $this->password = 'P@ssword';
    $this->super = User::factory()->create([
        'name' => 'Testing Super User',
        'email' => 'testing_super@garage.com',
        'password' => $this->password,
    ]);
    $this->super->assignRole(UserRole::SUPER->value);
    $this->country = Country::factory()->create();
});

it('successfully creates complete user details using create form', function () {

    // $file = UploadedFile::fake()->image('avatar.jpg');
    actingAs($this->super);

    visit('/users/create')
        ->fill('@name', 'Testing User')
        ->fill('@email', 'testing_user@garage.com')

        // #TODO - only uncomment when php-pest-browser-plugin have been fixed the thing with multipart/form-data
        // https://github.com/pestphp/pest-plugin-browser/pull/200
        // ->attach('image', $file)

        ->fill('@password', 'TestingP@ssword')
        ->fill('@password_confirmed', 'TestingP@ssword')
        ->select('@role', 'user_viewer')
        ->check('@active')

        ->fill('@address_number', '564')
        ->fill('@address_street', 'SunFlower Street')
        ->fill('@address_postcode', '893829')
        ->select('@address_country_id', $this->country->id)
        ->fill('@address_coordinates_latitude', '8.327832')
        ->fill('@address_coordinates_longitude', '94.676743')

        ->fill('@contact_mobile', '0788444666')
        ->fill('@contact_landline', '0112664773')
        ->fill('@contact_email', 'contact@garage.com')
        ->fill('@contact_url', 'https://garage.com')
        ->fill('@contact_info', 'Extra information about how to contact me')

        ->click('@form-users-create-submit')
        ->assertRoute('users.index');

    expect($this->super->team()->get())->toHaveCount(1);
});

it('successfully creates complete inactive user details using create form', function () {

    // $file = UploadedFile::fake()->image('avatar.jpg');
    actingAs($this->super);

    visit('/users/create')
        ->fill('@name', 'Testing User')
        ->fill('@email', 'testing_user@garage.com')

        // #TODO - only uncomment when php-pest-browser-plugin have been fixed the thing with multipart/form-data
        // https://github.com/pestphp/pest-plugin-browser/pull/200
        // ->attach('image', $file)

        ->fill('@password', 'TestingP@ssword')
        ->fill('@password_confirmed', 'TestingP@ssword')
        ->select('@role', 'user_viewer')

        ->fill('@address_number', '564')
        ->fill('@address_street', 'SunFlower Street')
        ->fill('@address_postcode', '893829')
        ->select('@address_country_id', $this->country->id)
        ->fill('@address_coordinates_latitude', '8.327832')
        ->fill('@address_coordinates_longitude', '94.676743')

        ->fill('@contact_mobile', '0788444666')
        ->fill('@contact_landline', '0112664773')
        ->fill('@contact_email', 'contact@garage.com')
        ->fill('@contact_url', 'https://garage.com')
        ->fill('@contact_info', 'Extra information about how to contact me')

        ->click('@form-users-create-submit')

        ->assertRoute('users.index');

    expect($this->super->team()->get())->toHaveCount(1);
    expect($this->super->team()->first()->active)->toBeFalse();
});

it('unsuccesfull create due to missing accurate information', function () {
    actingAs($this->super);

    visit('/users/create')
        ->fill('@password', 'TestingP@ssword')
        ->fill('@password_confirmed', 'TestingP@sswords')

        ->click('@form-users-create-submit')

        ->assertSee('The name field is required')
        ->assertSee('The email field is required')
        ->assertSee('The password confirmed field must match password')
        ->assertSee('The address.number field is required')
        ->assertSee('The address.street field is required')
        ->assertSee('The address.postcode field is required')
        ->assertSee('The address.coordinates.latitude field is required')
        ->assertSee('The address.coordinates.longitude field is required')
        ->assertSee('The contact.mobile field is required')
        ->assertSee('The contact.email field is required')

        ->assertRoute('users.create');
});

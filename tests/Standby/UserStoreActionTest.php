<?php

declare(strict_types=1);

use App\Actions\UserStoreAction;
use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR->value);

    $this->country = Country::factory()->create();
    $this->file = UploadedFile::fake()->image('avatar.jpg');

    $this->adminAction = new UserStoreAction($this->administrator);
});

test('should store user along with address & contact', function () {
    $this->adminAction->handle([
        'name' => 'Test User',
        'email' => 'testuser@garage.com',
        'password' => 'Password',
        'active' => true,
        'role' => UserRole::USER->value,
        'address' => [
            'number' => 123,
            'street' => 'Sunflower Street',
            'postcode' => 'B546BN',
            'extra' => 'Extra Information',
            'country_id' => $this->country->id,
            'coordinates' => [
                'latitude' => 9.4784783,
                'longitude' => 34.4378747,
            ]
        ],
        'contact' => [
            'mobile' => '0772993822',
            'landline' => '0112737728',
            'email' => 'contact@garage.com',
            'url' => 'http://example.com',
            'info' => 'Information'
        ],
    ]);

    $user = User::where('email', 'testuser@garage.com')->first();
    expect($user)->toBeInstanceOf(User::class);
    expect($user->addresses)->toHaveCount(1);
    expect($user->contacts)->toHaveCount(1);
    expect($this->admin->team()->get())->toHaveCount(1);
});

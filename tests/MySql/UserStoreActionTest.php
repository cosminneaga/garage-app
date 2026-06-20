<?php

declare(strict_types=1);

use App\Actions\UserStoreAction;
use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->country = Country::factory()->create();
    $this->file = UploadedFile::fake()->image('avatar.jpg');

    $this->action = new UserStoreAction();
});

test('should store user along with address & contact', function () {
    actingAs($this->administrator);
    $user = $this->action->handle([
        'name' => 'Test User',
        'email' => 'testuser@garage.com',
        'password' => 'Password',
        'active' => true,
        'role' => UserRole::USER->value,
        'address' => [
            'street_number' => 123,
            'street' => 'Sunflower Street',
            'postcode' => 'B546BN',
            'building' => 'B465',
            'floor' => 'Second Floor',
            'unit' => 'B5',
            'country_id' => $this->country->id,
            'coordinates' => [
                'latitude' => 9.4784783,
                'longitude' => 34.4378747,
            ],
        ],
        'contact' => [
            'mobile' => '0772993822',
            'landline' => '0112737728',
            'email' => 'contact@garage.com',
            'url' => 'http://example.com',
            'info' => 'Information',
        ],
    ]);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->addresses)->toHaveCount(1);
    expect($user->contacts)->toHaveCount(1);
    expect($user->created_by)->toEqual($this->administrator->id);
    expect($user->updated_by)->toEqual($this->administrator->id);
});

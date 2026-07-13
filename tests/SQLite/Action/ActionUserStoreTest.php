<?php

declare(strict_types=1);

use App\Actions\UserStoreAction;
use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\App;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);
    $this->country = Country::factory()->create();
});

test('should store user along with address & contact', function () {
    actingAs($this->manager);
    $user = App::make(UserStoreAction::class)->handle([
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
    expect($user->created_by)->toEqual($this->manager->id);
    expect($user->updated_by)->toEqual($this->manager->id);
});

test('handle: throw error when contact/address are missing', function () {
    actingAs($this->manager);

    expect(fn () => App::make(UserStoreAction::class)->handle([
        'name' => 'Test User',
        'email' => 'testuser@garage.com',
        'password' => 'Password',
        'active' => true,
        'role' => UserRole::USER->value,
    ]))->toThrow('Address & Contact are required when User data is stored');
});

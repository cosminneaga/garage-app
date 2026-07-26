<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\Address;
use App\Models\Country;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->manager = User::factory()->create();
    $this->user = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);
    $this->user->assignRole(UserRole::USER);
    $this->manager->memberAttach($this->user);

    $this->country = Country::factory()->create();
});

test('user: [with permissions] store user address', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::USER, 'update'),
        Permission::value(UserPermission::ADDRESS, 'store'),
    ]);
    $this->manager->memberAttach($user);
    actingAs($this->user);

    post(route('addresses.users.store', $user), [
        'street_number' => '76274',
        'street' => 'Buster Harbors',
        'postcode' => '51040-6389',
        'building' => '72760',
        'floor' => '857',
        'unit' => '36012',
        'country_id' => $this->country->id,
        'coordinates' => null,
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Resource created',
            'message' => 'Address has been created and attached to given resource',
        ]);
});

test('user: [with permissions] update user address', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $address = Address::factory()->create(['coordinates' => null]);
    $user->addresses()->attach($address);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::USER, 'update'),
        Permission::value(UserPermission::ADDRESS, 'update'),
    ]);
    $this->manager->memberAttach($user);
    actingAs($this->user);

    put(route('addresses.users.update', [$address, $user]), [
        'street_number' => '76274',
        'street' => 'Buster Harbors',
        'postcode' => '51040-6389',
        'building' => '72760',
        'floor' => '857',
        'unit' => '36012',
        'country_id' => $this->country->id,
        'coordinates' => null,
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Resource updated',
            'message' => 'Address updated successfully',
        ]);
});

test('user: [with permissions] destroy user address', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $address = Address::factory()->create(['coordinates' => null]);
    $user->addresses()->attach($address);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::USER, 'update'),
        Permission::value(UserPermission::ADDRESS, 'update'),
    ]);
    $this->manager->memberAttach($user);
    actingAs($this->user);

    delete(route('addresses.users.destroy', [$address, $user]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Resource removed',
            'message' => 'Address has been removed from given resource',
        ]);
});

<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\Contact;
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

test('user: [with permissions] store user contact', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::USER, 'update'),
        Permission::value(UserPermission::CONTACT, 'store'),
    ]);
    $this->manager->memberAttach($user);
    actingAs($this->user);

    post(route('contacts.users.store', $user), [
        'mobile' => '316-599-5131',
        'landline' => '781.446.9941',
        'email' => 'test@garage.com',
        'url' => 'http://example.com',
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Resource created',
            'message' => 'Contact has been created and attached to given resource',
        ]);
});

test('user: [with permissions] update user contact', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $contact = Contact::factory()->create();
    $user->contacts()->attach($contact);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::USER, 'update'),
        Permission::value(UserPermission::CONTACT, 'update'),
    ]);
    $this->manager->memberAttach($user);
    actingAs($this->user);

    put(route('contacts.users.update', [$contact, $user]), [
        'mobile' => '316-599-5131',
        'landline' => '781.446.9941',
        'email' => 'test@garage.com',
        'url' => 'http://example.com',
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Resource updated',
            'message' => 'Contact updated successfully',
        ]);
});

test('user: [with permissions] destroy user contact', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $contact = Contact::factory()->create();
    $user->contacts()->attach($contact);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::USER, 'update'),
        Permission::value(UserPermission::CONTACT, 'delete'),
    ]);
    $this->manager->memberAttach($user);
    actingAs($this->user);

    delete(route('contacts.users.destroy', [$contact, $user]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Resource removed',
            'message' => 'Contact has been removed from given resource',
        ]);
});

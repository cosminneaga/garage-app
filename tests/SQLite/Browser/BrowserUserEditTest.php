<?php

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Contact;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);

    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::USER);
    $this->manager->users()->attach($this->user);

    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create(['coordinates' => null]);
    $this->user->contacts()->attach($this->contact);
    $this->user->addresses()->attach($this->address);
});

test('manager: update users\'s details', function () {
    actingAs($this->manager);

    visit(route('users.edit', [$this->user]))
        ->assertSee($this->user->name)
        ->fill('@user_update_name', 'Cosmin Neaga')
        ->click('@form-user-update-submit')
        ->assertSee('User updated')
        ->assertSee('The user details have been successfully updated')
        ->assertDontSee($this->user->name)
        ->assertSee('Cosmin Neaga');
});

test('manager: delete user', function () {
    actingAs($this->manager);

    visit(route('users.edit', [$this->user]))
        ->click('@user-delete-modal-trigger')
        ->click('@user-delete-modal-confirm')
        ->assertRoute('users.index')
        ->assertDontSee($this->user->name);
});

test('manager: should see user\'s statistics', function () {
    actingAs($this->manager);

    visit(route('users.edit', [$this->user]))
        ->click('@statistics')
        ->assertSee($this->user->name . ' statistics');
});

test('manager: should add/remove contact', function () {
    actingAs($this->manager);

    visit(route('users.edit', [$this->user]))
        ->click('@contacts')
        ->click('@users-contact-create-modal-trigger')
        ->fill('@contact_mobile', '0777777777')
        ->fill('@contact_landline', '0111111111')
        ->fill('@contact_email', 'user@garage.com')
        ->fill('@contact_url', 'http://example.com')
        ->fill('@contact_info', 'The building is just around the corner')
        ->click('@users-contact-create-modal-submit')
        ->assertSee('Resource created')
        ->assertSee('Contact has been created and attached to given resource')
        ->assertSee('user@garage.com')
        ->click('@users-contact-delete-' . $this->contact->id . '-modal-trigger')
        ->click('@users-contact-delete-' . $this->contact->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Contact has been removed from given resource')
        ->assertDontSee($this->contact->email);
});

test('manager: should add/remove address', function () {
    actingAs($this->manager);

    visit(route('users.edit', [$this->user]))
        ->click('@addresses')
        ->click('@users-address-create-modal-trigger')
        ->fill('@address_street_number', '123')
        ->fill('@address_street', 'Flower Street')
        ->fill('@address_postcode', '123456')
        ->click('@users-address-create-modal-submit')
        ->assertSee('Resource created')
        ->assertSee('Address has been created and attached to given resource')
        ->assertSee('Flower Street')
        ->click('@users-address-delete-' . $this->address->id . '-modal-trigger')
        ->click('@users-address-delete-' . $this->address->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Address has been removed from given resource')
        ->assertDontSee($this->address->street);
});

test('manager: should assign/revoke permission', function () {
    actingAs($this->manager);

    visit(route('users.edit', [$this->user]))
        ->click('@permissions')
        ->assertDontSee('Revoke')
        ->click('@company-store-assign')
        ->assertSee('Permission assigned')
        ->assertSee('Permission assigned to user ' . $this->user->name)
        ->assertSee('Revoke')
        ->click('@company-store-revoke')
        ->assertSee('Permission revoked')
        ->assertSee('Permission revoked from user ' . $this->user->name)
        ->assertDontSee('Revoke');
});

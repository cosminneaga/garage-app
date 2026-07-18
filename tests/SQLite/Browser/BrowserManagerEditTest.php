<?php

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Contact;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);
    $this->administrator->managers()->attach($this->manager);

    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create(['coordinates' => null]);
    $this->manager->contacts()->attach($this->contact);
    $this->manager->addresses()->attach($this->address);
});

test('administrator: update manager\'s details', function () {
    actingAs($this->administrator);

    visit(route('managers.edit', [$this->manager]))
        ->assertSee($this->manager->name)
        ->fill('@manager_update_name', 'Cosmin Neaga')
        ->click('@form-manager-update-submit')
        ->assertSee('Manager updated')
        ->assertSee('The manager details have been successfully updated')
        ->assertDontSee($this->manager->name)
        ->assertSee('Cosmin Neaga');
});

test('administrator: delete manager', function () {
    actingAs($this->administrator);

    visit(route('managers.edit', [$this->manager]))
        ->click('@manager-delete-modal-trigger')
        ->click('@manager-delete-modal-confirm')
        ->assertRoute('managers.index')
        ->assertDontSee($this->manager->name);
});

test('administrator: should see manager\'s statistics', function () {
    actingAs($this->administrator);

    visit(route('managers.edit', [$this->manager]))
        ->click('@statistics')
        ->assertSee($this->manager->name . ' statistics');
});

test('administrator: should add/remove contact', function () {
    actingAs($this->administrator);

    visit(route('managers.edit', [$this->manager]))
        ->click('@contacts')
        ->click('@users-contact-create-modal-trigger')
        ->fill('@contact_mobile', '0777777777')
        ->fill('@contact_landline', '0111111111')
        ->fill('@contact_email', 'manager@garage.com')
        ->fill('@contact_url', 'http://example.com')
        ->fill('@contact_info', 'The building is just around the corner')
        ->click('@users-contact-create-modal-submit')
        ->assertSee('Resource created')
        ->assertSee('Contact has been created and attached to given resource')
        ->assertSee('manager@garage.com')
        ->click('@users-contact-delete-' . $this->contact->id . '-modal-trigger')
        ->click('@users-contact-delete-' . $this->contact->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Contact has been removed from given resource')
        ->assertDontSee($this->contact->email);
});

test('administrator: should add/remove address', function () {
    actingAs($this->administrator);

    visit(route('managers.edit', [$this->manager]))
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

test('administrator: should assign/revoke permission', function () {
    actingAs($this->administrator);

    visit(route('managers.edit', [$this->manager]))
        ->click('@permissions')
        ->assertDontSee('Revoke')
        ->click('@company-store-assign')
        ->assertSee('Permission assigned')
        ->assertSee('Permission assigned to user ' . $this->manager->name)
        ->assertSee('Revoke')
        ->click('@company-store-revoke')
        ->assertSee('Permission revoked')
        ->assertSee('Permission revoked from user ' . $this->manager->name)
        ->assertDontSee('Revoke');
});

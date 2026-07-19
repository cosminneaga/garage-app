<?php

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Contact;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create(['coordinates' => null]);
    $this->administrator->contacts()->attach($this->contact);
    $this->administrator->addresses()->attach($this->address);
});

test('administrator: update my profile', function () {
    actingAs($this->administrator);

    visit(route('profile.users.edit'))
        ->assertValue('@profile_update_name', $this->administrator->name)
        ->fill('@profile_update_name', 'Cosmin Neaga')
        ->click('@profile-update-submit')
        ->assertSee('Profile updated')
        ->assertSee('Your profile has been updated successfully');

    $this->administrator->refresh();
    visit(route('profile.users.edit'))
        ->assertValue('@profile_update_name', 'Cosmin Neaga');
});

test('administrator: see statistics', function () {
    actingAs($this->administrator);

    visit(route('profile.users.edit'))
        ->click('@statistics')
        ->assertSee('Stats goes here');
});

test('administrator: should add/remove contact', function () {
    actingAs($this->administrator);

    visit(route('profile.users.edit'))
        ->click('@contacts')
        ->click('@users-contact-create-modal-trigger')
        ->fill('@contact_mobile', '0777777777')
        ->fill('@contact_landline', '0111111111')
        ->fill('@contact_email', 'admin.update@garage.com')
        ->fill('@contact_url', 'http://example.com')
        ->fill('@contact_info', 'The building is just around the corner')
        ->click('@users-contact-create-modal-submit')
        ->assertSee('Resource created')
        ->assertSee('Contact has been created and attached to given resource');

    $this->administrator->refresh();
    visit(route('profile.users.edit', ['tab' => 'contacts']))
        ->assertSee('admin.update@garage.com')
        ->click('@users-contact-delete-' . $this->contact->id . '-modal-trigger')
        ->click('@users-contact-delete-' . $this->contact->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Contact has been removed from given resource');

    $this->administrator->refresh();
    visit(route('profile.users.edit', ['tab' => 'contacts']))
        ->assertDontSee($this->contact->email);
});

test('administrator: should add/remove address', function () {
    actingAs($this->administrator);

    visit(route('profile.users.edit'))
        ->click('@addresses')
        ->click('@users-address-create-modal-trigger')
        ->fill('@address_street_number', '123')
        ->fill('@address_street', 'Flower Street')
        ->fill('@address_postcode', '123456')
        ->click('@users-address-create-modal-submit')
        ->assertSee('Resource created')
        ->assertSee('Address has been created and attached to given resource');

    $this->administrator->refresh();
    visit(route('profile.users.edit', ['tab' => 'addresses']))
        ->assertSee('Flower Street')
        ->click('@users-address-delete-' . $this->address->id . '-modal-trigger')
        ->click('@users-address-delete-' . $this->address->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Address has been removed from given resource');

    $this->administrator->refresh();
    visit(route('profile.users.edit', ['tab' => 'addresses']))
        ->assertDontSee($this->address->street);
});

test('administrator: should see settings page', function () {
    actingAs($this->administrator);

    visit(route('profile.users.edit'))
        ->click('@settings')
        ->assertSee('User application settings');
});

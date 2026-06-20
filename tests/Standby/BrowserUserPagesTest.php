<?php

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Contact;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->password = 'P@ssword';
    $this->super = User::factory()->create([
        'name' => 'Testing Super User',
        'email' => 'testing_super@garage.com',
        'password' => $this->password,
    ]);
    $this->super->assignRole(UserRole::SUPER);

    $this->users = User::factory()->createMany([
        ['name' => 'User1'],
        ['name' => 'User2'],
        ['name' => 'User3'],
    ]);
    $this->super->team()->attach($this->users);

    $this->contact = Contact::factory()->create();
    $this->users[0]->contacts()->attach($this->contact);

    $this->address = Address::factory()->create([
        'coordinates' => null,
    ]);
    $this->users[0]->addresses()->attach($this->address);

    actingAs($this->super);
});

it('should see team members in team table', function () {
    visit(route('users.index'))
        ->assertSee('User1')
        ->assertSee('User2')
        ->assertSee('User3');
});

it('should see team members in team table & removed table', function () {
    $this->removedUser = $this->super->team()->where('name', 'User3')->first();

    visit(route('users.index'))
        ->assertSee('User1')
        ->assertSee('User2')
        ->assertSee('User3')
        ->click('@user-delete-' . $this->removedUser->id . '-modal-trigger')
        ->click('@user-delete-' . $this->removedUser->id . '-modal-confirm')
        ->assertSee('User1')
        ->assertSee('User2')
        ->assertDontSee('User3');

    visit(route('users.removed'))
        ->assertSee('User3')
        ->click('@user-restore-' . $this->removedUser->id . '-modal-trigger')
        ->click('@user-restore-' . $this->removedUser->id . '-modal-confirm')
        ->assertDontSee('User3');

    visit(route('users.index'))
        ->assertSee('User1')
        ->assertSee('User2')
        ->assertSee('User3');
});

it('should see user details', function () {
    visit(route('users.edit', $this->users[0]))
        ->click('@statistics')
        ->assertSee('Stats goes here')
        ->click('@contacts')
        ->assertSee($this->contact->email)
        ->click('@addresses')
        ->assertSee($this->address->street);
});


it('should update user', function () {
    visit(route('users.edit', $this->users[0]))
        ->assertSee($this->users[0]->name)
        ->fill('@user_update_name', 'Updated Name')
        ->click('@form-user-update-submit')
        ->assertSee('Updated Name')
        ->assertDontSee($this->users[0]->name)
        ->assertSee('User updated');
});


it('should remove user', function () {
    visit(route('users.edit', $this->users[0]))
        ->click('@user-delete-modal-trigger')
        ->click('@user-delete-modal-confirm')
        ->assertDontSee($this->users[0]->name)
        ->assertRoute('users.index');
});


it('should add contact', function () {
    visit(route('users.edit', $this->users[0]))
        ->click('@contacts')
        ->click('@users-contact-create-modal-trigger')
        ->fill('@contact_mobile', '0777299123')
        ->fill('@contact_landline', '0112299123')
        ->fill('@contact_email', 'contact@garage.com')
        ->fill('@contact_url', 'http://example.com')
        ->fill('@contact_info', 'More Information')
        ->click('@users-contact-create-modal-submit')
        ->assertSee('contact@garage.com');
});

it('should remove contact', function () {
    $contact = Contact::factory()->create();
    $this->users[0]->contacts()->attach($contact);

    visit(route('users.edit', $this->users[0]))
        ->click('@contacts')
        ->assertSee($contact->email)
        ->click('@users-contact-delete-' . $contact->id . '-modal-trigger')
        ->click('@users-contact-delete-' . $contact->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Contact has been removed from given resource')
        ->assertDontSee($contact->email);
});

it('should FAIL TEMPORARELY add address', function () {
    visit(route('users.edit', $this->users[0]))
        ->click('@addresses')
        ->click('@users-address-create-modal-trigger')
        ->fill('@address_number', '123')
        ->fill('@address_street', 'Flower Street')
        ->fill('@address_postcode', '123456')
        // ->fill('@coordinates_latitude', '52.370216')
        // ->fill('@coordinates_longitude', '4.895168')
        ->fill('@address_extra', 'The building is just around the corner')
        ->click('@users-address-create-modal-submit')
        ->assertSee('The coordinates.latitude field must be a string.')
        ->assertSee('The coordinates.longitude field must be a string.');
});

it('should remove address', function () {
    visit(route('users.edit', $this->users[0]))
        ->click('@addresses')
        ->assertSee($this->address->street)
        ->click('@users-address-delete-' . $this->address->id . '-modal-trigger')
        ->click('@users-address-delete-' . $this->address->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Address has been removed from given resource')
        ->assertDontSee($this->address->street);
});

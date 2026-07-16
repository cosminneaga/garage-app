<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Supplier;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->manager = User::factory()->create();
    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();

    $this->manager_contact = Contact::factory()->create();
    $this->company_contact = Contact::factory()->create();
    $this->supplier_contact = Contact::factory()->create();
    $this->manager->contacts()->attach($this->manager_contact);
    $this->company->contacts()->attach($this->company_contact);
    $this->supplier->contacts()->attach($this->supplier_contact);
});

test('administrator: should edit manager\'s contact', function () {
    $this->administrator->managers()->attach($this->manager);
    actingAs($this->administrator);

    visit(route('contacts.users.edit', [$this->manager_contact, $this->manager]))
        ->assertValue('@contact_email', $this->manager_contact->email)
        ->assertValue('@contact_mobile', $this->manager_contact->mobile)
        ->fill('@contact_email', 'test@garage.com')
        ->fill('@contact_mobile', '(469) 890-0745')
        ->click('@contact_update')
        ->assertSee('Resource updated')
        ->assertSee('Contact updated successfully')
        ->assertValue('@contact_email', 'test@garage.com')
        ->assertValue('@contact_mobile', '(469) 890-0745');
});

test('administrator: should edit company contact', function () {
    $this->administrator->companies()->attach($this->company);
    actingAs($this->administrator);

    visit(route('contacts.companies.edit', [$this->company_contact, $this->company]))
        ->assertValue('@contact_email', $this->company_contact->email)
        ->assertValue('@contact_mobile', $this->company_contact->mobile)
        ->fill('@contact_email', 'test@garage.com')
        ->fill('@contact_mobile', '(469) 890-0745')
        ->click('@contact_update')
        ->assertSee('Resource updated')
        ->assertSee('Contact updated successfully')
        ->assertValue('@contact_email', 'test@garage.com')
        ->assertValue('@contact_mobile', '(469) 890-0745');
});

test('administrator: should edit supplier contact', function () {
    $this->administrator->companies()->attach($this->company);
    $this->company->suppliers()->attach($this->supplier);
    actingAs($this->administrator);

    visit(route('contacts.suppliers.edit', [$this->supplier_contact, $this->supplier]))
        ->assertValue('@contact_email', $this->supplier_contact->email)
        ->assertValue('@contact_mobile', $this->supplier_contact->mobile)
        ->fill('@contact_email', 'test@garage.com')
        ->fill('@contact_mobile', '(469) 890-0745')
        ->click('@contact_update')
        ->assertSee('Resource updated')
        ->assertSee('Contact updated successfully')
        ->assertValue('@contact_email', 'test@garage.com')
        ->assertValue('@contact_mobile', '(469) 890-0745');
});

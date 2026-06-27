<?php

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Supplier;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->companies = Company::factory()->createMany([
        ['name' => 'Company One'],
        ['name' => 'Company Two'],
    ]);
    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create(['coordinates' => null]);
    $this->supplier = Supplier::factory()->create();

    $this->contact->companies()->attach($this->companies);
    $this->address->companies()->attach($this->companies);
    $this->supplier->companies()->attach($this->companies);
    $this->administrator->companies()->attach($this->companies);

    $this->visitIndex = visit(route('companies.index'));
});

test('administrator: should see only own companies listing table', function () {
    actingAs($this->administrator);
    Company::factory()->createMany([
        ['name' => 'Company External'],
    ]);

    visit(route('companies.index'))
        ->assertSee('Company One')
        ->assertSee('Company Two')
        ->assertDontSee('Company External');
});

test('administrator: should test successfully removing/restoring company', function () {
    actingAs($this->administrator);
    visit(route('companies.index'))
        ->assertSee('Company One')
        ->assertSee('Company Two')
        ->click('@company-delete-' . $this->companies[0]->id . '-modal-trigger')
        ->click('@company-delete-' . $this->companies[0]->id . '-modal-confirm')
        ->assertDontSee('Company One');

    visit(route('companies.removed'))
        ->assertSee('Company One')
        ->click('@company-restore-' . $this->companies[0]->id . '-modal-trigger')
        ->click('@company-restore-' . $this->companies[0]->id . '-modal-confirm')
        ->assertDontSee('Company One');

    visit(route('companies.index'))
        ->assertSee('Company One')
        ->assertSee('Company Two');
});

test('administrator: should see company details', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->assertSee($this->companies[0]->name)
        ->click('@statistics')
        ->assertSee('Data goes here')
        ->click('@members')
        ->assertSee($this->administrator->name)
        ->click('@contacts')
        ->assertSee($this->contact->email)
        ->click('@addresses')
        ->assertSee($this->address->street)
        ->click('@suppliers')
        ->assertSee($this->supplier->name);
});

test('administrator: should update company details', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->fill('@company_name', 'Updated Company Name')
        ->click('@form-company-update-button')
        ->assertSee('Company updated')
        ->assertSee('The company details have been successfully updated.');
});

test('administrator: should remove company', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@company-delete-modal-trigger')
        ->click('@company-delete-modal-confirm')
        ->assertDontSee($this->companies[0]->name)
        ->assertRoute('companies.index');
});

test('administrator: should add an existing manager', function () {
    $managers = User::factory(2)->create();
    $this->administrator->managers()->attach($managers);

    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@members')
        ->click('companies-user-create-modal-trigger')
        ->select('@user_select_id', $managers[1]->id)
        ->click('@companies-user-create-modal-submit-attach')
        ->assertSee('User added')
        ->assertSee('Existing user has been attached to your company')
        ->assertSee($managers[1]->name);
});

test('administrator: should create a new manager', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@members')
        ->click('@companies-user-create-modal-trigger')
        ->fill('@user_name', 'Manager Test')
        ->fill('@user_email', 'manager.test@garage.com')
        ->fill('@user_password', 'Password')
        ->fill('@user_password_confirmed', 'Password')
        ->select('@user_role', 'manager')
        ->check('@user_active')
        ->fill('@user_address_street_number', '324')
        ->fill('@user_address_street', 'Sunflower Street')
        ->fill('@user_address_postcode', 'B434BNB')
        ->fill('@user_contact_mobile', '0744444444')
        ->fill('@user_contact_landline', '0112111111')
        ->fill('@user_contact_email', 'manager.test@garage.com')
        ->click('@companies-user-create-modal-submit-resource')
        ->assertSee('User created')
        ->assertSee('User created and attached to your team & company')
        ->assertSee('Manager Test');
});

test('administrator: should remove a member', function () {
    $manager = User::factory()->create();
    $this->administrator->managers()->attach($manager);
    $this->companies[0]->users()->attach($manager);

    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@members')
        ->click('@user-company-delete-' . $manager->id . '-modal-trigger')
        ->click('@user-company-delete-' . $manager->id . '-modal-confirm')
        ->assertSee('User removed')
        ->assertSee('Existing user has been deattached from your company')
        ->assertDontSee($manager->name);
});

test('administrator: should add contact', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@contacts')
        ->click('@companies-contact-create-modal-trigger')
        ->fill('@contact_mobile', '0777777777')
        ->fill('@contact_landline', '0111111111')
        ->fill('@contact_email', 'companycontact@garage.com')
        ->fill('@contact_url', 'http://example.com')
        ->fill('@contact_info', 'The building is just around the corner')
        ->click('@companies-contact-create-modal-submit')
        ->assertSee('companycontact@garage.com');
});

test('administrator: should remove contact', function () {
    $contact = Contact::factory()->create();
    $this->companies[0]->contacts()->attach($contact);
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@contacts')
        ->assertSee($contact->email)
        ->click('@companies-contact-delete-' . $contact->id . '-modal-trigger')
        ->click('@companies-contact-delete-' . $contact->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Contact has been removed from given resource')
        ->assertDontSee($contact->email);
});

test('administrator: should add address', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@addresses')
        ->click('@companies-address-create-modal-trigger')
        ->fill('@address_street_number', '123')
        ->fill('@address_street', 'Flower Street')
        ->fill('@address_postcode', '123456')->wait(1)
        ->click('@companies-address-create-modal-submit')
        ->assertSee('Resource created')
        ->assertSee('Address has been created and attached to given resource');
});

test('administrator: should remove address', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@addresses')
        ->assertSee($this->address->street)
        ->click('@companies-address-delete-' . $this->address->id . '-modal-trigger')
        ->click('@companies-address-delete-' . $this->address->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Address has been removed from given resource')
        ->assertDontSee($this->address->street);
});

test('administrator: should add supplier', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@suppliers')
        ->click('@companies-supplier-create-modal-trigger')
        ->fill('@supplier_name', 'Supplier Test')
        ->fill('@supplier_code', 'SUPTEST123')
        ->select('@supplier_type', 'distributor')
        ->fill('@supplier_tax_id', '3644758439')
        ->fill('@supplier_registration_number', '3644758439')
        ->fill('@supplier_address_street_number', '2566')
        ->fill('@supplier_address_street', 'Subway Street')
        ->fill('@supplier_address_postcode', 'B546FBN')
        ->fill('@supplier_contact_mobile', '0777777777')
        ->fill('@supplier_contact_landline', '0111111111')
        ->fill('@supplier_contact_email', 'supplier_test@garage.com')
        ->fill('@supplier_contact_url', 'http://example.com')
        ->fill('@supplier_contact_info', 'Extra contact information')
        ->click('@companies-supplier-create-modal-submit')
        ->assertSee('Supplier Test');
});

test('administrator: should remove supplier', function () {
    actingAs($this->administrator);
    visit(route('companies.edit', $this->companies[0]))
        ->click('@suppliers')
        ->click('@supplier-delete-' . $this->supplier->id . '-modal-trigger')
        ->click('@supplier-delete-' . $this->supplier->id . '-modal-confirm')
        ->assertSee('Supplier removed')
        ->assertSee('Supplier has been successfully removed');
});

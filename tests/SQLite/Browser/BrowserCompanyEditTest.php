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
    $this->company = Company::factory()->create(['name' => 'Company']);
    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create(['coordinates' => null]);
    $this->supplier = Supplier::factory()->create();

    $this->contact->companies()->attach($this->company);
    $this->address->companies()->attach($this->company);
    $this->supplier->companies()->attach($this->company);
    $this->administrator->companies()->attach($this->company);

    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);
    $this->administrator->managers()->attach($this->manager);
});

test('administrator: should see company details', function () {
    actingAs($this->administrator);

    visit(route('companies.edit', $this->company))
        ->assertSee($this->company->name)
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

    visit(route('companies.edit', $this->company))
        ->fill('@company-update_name', 'Updated Company Name')
        ->click('@form-company-update-submit')
        ->assertSee('Company updated')
        ->assertSee('The company details have been successfully updated.');
});

test('administrator: should remove company', function () {
    actingAs($this->administrator);

    visit(route('companies.edit', $this->company))
        ->click('@company-delete-modal-trigger')
        ->click('@company-delete-modal-confirm')
        ->assertDontSee($this->company->name)
        ->assertRoute('companies.index');
});

# App\Http\Controllers\UserController.php->modelAttach()
# App\Http\Controllers\UserController.php->modelDetach()
test('administrator: should attach/remove manager', function () {
    actingAs($this->administrator);

    visit(route('companies.edit', $this->company))
        ->click('@members')
        ->assertDontSee($this->manager->name)
        ->click('@companies-user-attach-modal-trigger')
        ->click('@user-attach-' . $this->manager->id . '-button')
        ->assertSee('User linked')
        ->assertSee('User has been linked to company')
        ->assertSee($this->manager->name)
        ->click('@user-company-delete-' . $this->manager->id . '-modal-trigger')
        ->click('@user-company-delete-' . $this->manager->id . '-modal-confirm')
        ->assertSee('User unlinked')
        ->assertSee('User has been unlinked from company')
        ->assertDontSee($this->manager->name);
});

test('administrator: should add/remove contact', function () {
    actingAs($this->administrator);

    visit(route('companies.edit', $this->company))
        ->click('@contacts')
        ->click('@companies-contact-create-modal-trigger')
        ->fill('@contact_mobile', '0777777777')
        ->fill('@contact_landline', '0111111111')
        ->fill('@contact_email', 'companycontact@garage.com')
        ->fill('@contact_url', 'http://example.com')
        ->fill('@contact_info', 'The building is just around the corner')
        ->click('@companies-contact-create-modal-submit')
        ->assertSee('Resource created')
        ->assertSee('Contact has been created and attached to given resource')
        ->assertSee('companycontact@garage.com')
        ->click('@companies-contact-delete-' . $this->contact->id . '-modal-trigger')
        ->click('@companies-contact-delete-' . $this->contact->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Contact has been removed from given resource')
        ->assertDontSee($this->contact->email);
});

test('administrator: should add/remove address', function () {
    actingAs($this->administrator);

    visit(route('companies.edit', $this->company))
        ->click('@addresses')
        ->click('@companies-address-create-modal-trigger')
        ->fill('@address_street_number', '123')
        ->fill('@address_street', 'Flower Street')
        ->fill('@address_postcode', '123456')
        ->click('@companies-address-create-modal-submit')
        ->assertSee('Resource created')
        ->assertSee('Address has been created and attached to given resource')
        ->assertSee('Flower Street')
        ->click('@companies-address-delete-' . $this->address->id . '-modal-trigger')
        ->click('@companies-address-delete-' . $this->address->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Address has been removed from given resource')
        ->assertDontSee($this->address->street);
});

test('administrator: should add/remove supplier', function () {
    actingAs($this->administrator);

    visit(route('companies.edit', $this->company))
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
        ->assertSee('Supplier Test')
        ->click('@supplier-delete-' . $this->supplier->id . '-modal-trigger')
        ->click('@supplier-delete-' . $this->supplier->id . '-modal-confirm')
        ->assertSee('Supplier removed')
        ->assertSee('Supplier information has been successfully removed from respective company')
        ->assertDontSee($this->supplier->name);
});

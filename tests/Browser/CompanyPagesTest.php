<?php

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Supplier;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->password = 'P@ssword';
    $this->super = User::factory()->create([
        'name' => 'Testing Super User',
        'email' => 'testing_super@garage.com',
        'password' => $this->password,
    ]);
    $this->super->assignRole(UserRole::SUPER->value);

    $this->companies = Company::factory()->createMany([
        ['name' => 'Company1'],
        ['name' => 'Company2'],
        ['name' => 'Company3'],
    ]);
    $this->super->companies()->attach($this->companies);

    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create([
        'coordinates' => null // cancel inserting coordinates as this works only in a real MySQL database
    ]);
    $this->supplier = Supplier::factory()->create();
    $this->companies[0]->contacts()->attach($this->contact);
    $this->companies[0]->addresses()->attach($this->address);
    $this->companies[0]->suppliers()->attach($this->supplier);

    actingAs($this->super);
});

it('should see companies in companies table', function () {
    visit(route('companies.index'))
        ->assertSee('Company1')
        ->assertSee('Company2')
        ->assertSee('Company3');
});

it('should see companies in companies & removed table', function () {
    $this->removedCompany = $this->super->companies()->where('name', 'Company3')->first();

    visit(route('companies.index'))
        ->assertSee('Company1')
        ->assertSee('Company2')
        ->assertSee('Company3')
        ->click('@company-delete-' . $this->removedCompany->id . '-modal-trigger')
        ->click('@company-delete-' . $this->removedCompany->id .'-modal-confirm')
        ->assertSee('Company1')
        ->assertSee('Company2')
        ->assertDontSee('Company3');

    visit(route('companies.removed'))
        ->assertSee('Company3')
        ->click('@company-restore-' . $this->removedCompany->id .'-modal-trigger')
        ->click('@company-restore-' . $this->removedCompany->id . '-modal-confirm')
        ->assertDontSee('Company3');

    visit(route('companies.index'))
        ->assertSee('Company1')
        ->assertSee('Company2')
        ->assertSee('Company3');
});

it('should see company details', function () {
    visit(route('companies.edit', $this->companies[0]))
        ->assertSee($this->companies[0]->name)
        ->click('@statistics')
        ->assertSee('Data goes here')
        ->click('@members')
        ->assertSee($this->super->name)
        ->click('@contacts')
        ->assertSee($this->contact->email)
        ->click('@addresses')
        ->assertSee($this->address->street)
        ->click('@suppliers')
        ->assertSee($this->supplier->name);
});

it('should update company details', function () {
    visit(route('companies.edit', $this->companies[0]))
        ->fill('@company_name', 'Updated Company Name')
        ->click('@form-company-update-button')
        ->assertSee('Company updated')
        ->assertSee('The company details have been successfully updated.');
});

it('should remove company', function () {
    visit(route('companies.edit', $this->companies[0]))
        ->click('@company-delete-modal-trigger')
        ->click('@company-delete-modal-confirm')
        ->assertDontSee($this->companies[0]->name)
        ->assertRoute('companies.index');
});

it('should add & remove member', function () {
    // !NOTE: We should add a button to add/create members and attach it to current company

    visit(route('companies.edit', $this->companies[0]))
        ->click('@members')
        ->assertSee($this->super->name);
});

it('should add contact', function () {
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

it('should remove contact', function () {
    $contact = Contact::factory()->create();
    $this->companies[0]->contacts()->attach($contact);

    visit(route('companies.edit', $this->companies[0]))
        ->click('@contacts')
        ->assertSee($contact->email)
        ->click('@companies-contact-delete-' . $contact->id . '-modal-trigger')
        ->click('@companies-contact-delete-' . $contact->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Contact has been removed from given resource')
        ->assertDontSee($contact->email);
});

it('should FAIL TEMPORARELY add address', function () {
    visit(route('companies.edit', $this->companies[0]))
        ->click('@addresses')
        ->click('@companies-address-create-modal-trigger')
        ->fill('@address_number', '123')
        ->fill('@address_street', 'Flower Street')
        ->fill('@address_postcode', '123456')
        // ->fill('@coordinates_latitude', '52.370216')
        // ->fill('@coordinates_longitude', '4.895168')
        ->fill('@address_extra', 'The building is just around the corner')
        ->click('@companies-address-create-modal-submit')
        ->assertSee('The coordinates.latitude field must be a string.')
        ->assertSee('The coordinates.longitude field must be a string.');
});

it('should remove address', function () {
    actingAs($this->super);

    visit(route('companies.edit', $this->companies[0]))
        ->click('@addresses')
        ->assertSee($this->address->street)
        ->click('@companies-address-delete-' . $this->address->id . '-modal-trigger')
        ->click('@companies-address-delete-' . $this->address->id . '-modal-confirm')
        ->assertSee('Resource removed')
        ->assertSee('Address has been removed from given resource')
        ->assertDontSee($this->address->street);
});

it('should add supplier', function () {
    visit(route('companies.edit', $this->companies[0]))
        ->click('@suppliers')
        ->click('@companies-supplier-create-modal-trigger')
        ->fill('@supplier_name', 'Supplier Test')
        ->fill('@supplier_code', 'SUPTEST123')
        // ->fill('@supplier_type', 'distributor')
        ->fill('@supplier_tax_id', '3644758439')
        ->fill('@supplier_registration_number', '3644758439')
        ->fill('@supplier_address_number', '2566')
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


it('should remove supplier', function () {
    visit(route('companies.edit', $this->companies[0]))
        ->click('@suppliers')
        ->click('@supplier-delete-' . $this->supplier->id . '-modal-trigger')
        ->click('@supplier-delete-' . $this->supplier->id . '-modal-confirm')
        ->assertSee('Supplier removed')
        ->assertSee('Supplier has been successfully removed');
});

<?php

use App\Enums\SupplierType;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->manager = User::factory()->create();
    $this->user = User::factory()->create();

    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->manager->assignRole(UserRole::MANAGER);
    $this->user->assignRole(UserRole::USER);

    $this->administrator->managers()->attach($this->manager);
    $this->manager->users()->attach($this->user);

    $this->company = Company::factory()->create();
    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create(['coordinates' => null]);
    $this->supplier = Supplier::factory()->create();
    $this->country = Country::factory()->create();

    $this->company->users()->attach([
        $this->administrator,
        $this->manager,
        $this->user,
    ]);

    $this->company->contacts()->attach($this->contact);
    $this->company->addresses()->attach($this->address);
    $this->company->suppliers()->attach($this->supplier);
});

/* ----------------------------- companies.index ---------------------------- */
test('administrator: fetch companies', function () {
    actingAs($this->administrator);

    get(route('companies.index'))
        ->assertStatus(200)
        ->assertSee($this->company->name);
});

test('manager: fetch companies', function () {
    actingAs($this->manager);

    get(route('companies.index'))
        ->assertStatus(200)
        ->assertSee($this->company->name);
});

test('user: fetch companies', function () {
    actingAs($this->user);

    get(route('companies.index'))
        ->assertStatus(200)
        ->assertSee($this->company->name);
});

test('user: should not see companies that are not attached', function () {
    $company = Company::factory()->create();
    actingAs($this->user);

    get(route('companies.index'))
        ->assertStatus(200)
        ->assertSee($this->company->name)
        ->assertDontSee($company->name);
});

test('user: filter companies', function () {
    $companies = Company::factory()->createMany([
        ['name' => 'One'],
        ['name' => 'Two'],
    ]);
    $this->user->companies()->attach($companies);
    actingAs($this->user);

    get(route('companies.index', ['search' => 'One']))
        ->assertStatus(200)
        ->assertSee('One')
        ->assertDontSee('Two');
});

test('no auth: should not see company if not authenticated', function () {
    get(route('companies.index'))
        ->assertStatus(302)
        ->assertDontSee($this->company->name)
        ->assertRedirectToRoute('login');
});


/* ----------------------------- companies.edit ----------------------------- */
test('user: should be able to see company details', function () {
    actingAs($this->user);

    get(route('companies.edit', $this->company))
        ->assertStatus(200)
        ->assertSee($this->company->name);
});

test('user: statistics', function () {
    actingAs($this->user);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'statistics',
    ]))
        ->assertStatus(200)
        ->assertSee('Data goes here');
});

test('user: members [should not be able to see attached manager & administrator]', function () {
    actingAs($this->user);
    $this->company->users()->attach([$this->administrator, $this->manager, $this->user]);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'members',
    ]))
        ->assertSee($this->user->name)
        ->assertDontSee($this->manager->name)
        ->assertDontSee($this->administrator->name);
});

test('user: contacts, see, add & remove', function () {
    actingAs($this->user);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::CONTACT, 'store'),
        Permission::value(UserPermission::CONTACT, 'delete'),
        Permission::value(UserPermission::COMPANY, 'update'),

    ]);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'contacts',
    ]))
        ->assertStatus(200);

    post(route('contacts.companies.store', $this->company), [
        'email' => 'contact@garage.com',
        'mobile' => '98291829819',
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Resource created',
            'message' => 'Contact has been created and attached to given resource',
        ]);

    delete(route('contacts.companies.destroy', [
        'contact' => $this->contact,
        'company' => $this->company,
    ]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Resource removed',
            'message' => 'Contact has been removed from given resource',
        ]);
});

test('user: addresses, see, add & remove', function () {
    actingAs($this->user);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::ADDRESS, 'store'),
        Permission::value(UserPermission::ADDRESS, 'delete'),
        Permission::value(UserPermission::COMPANY, 'update'),
    ]);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'addresses',
    ]))
        ->assertStatus(200);

    post(route('addresses.companies.store', $this->company), [
        'street_number' => '123',
        'street' => 'Sunflower Street',
        'postcode' => 'B345BN',
        'country_id' => Country::factory()->create()->id,
        'coordinates' => null,
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Resource created',
            'message' => 'Address has been created and attached to given resource',
        ]);

    delete(route('addresses.companies.destroy', [
        'address' => $this->address,
        'company' => $this->company,
    ]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Resource removed',
            'message' => 'Address has been removed from given resource',
        ]);
});

test('user: supplier, see, add & remove', function () {
    actingAs($this->user);
    $this->user->givePermissionTo([
        Permission::value(UserPermission::SUPPLIER, 'store'),
        Permission::value(UserPermission::SUPPLIER, 'delete'),
        Permission::value(UserPermission::COMPANY, 'update'),
    ]);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'suppliers',
    ]))
        ->assertStatus(200);

    post(route('suppliers.companies.store', $this->company), [
        'name' => 'Supplier Test',
        'code' => 'SUPTEST',
        'type' => SupplierType::DISTRIBUTOR->value,
        'tax_id' => '873287382',
        'registration_number' => '843874837483',
        'contact' => [
            'email' => 'supplier@garage.com',
            'mobile' => '837287382783',
        ],
        'address' => [
            'street_number' => '123',
            'street' => 'Sunflower Street',
            'postcode' => 'B345BN',
            'country_id' => $this->country->id,
            'coordinates' => null,
        ],
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Supplier created',
            'message' => 'Supplier information has been created and attached to respective company',
        ]);

    delete(route('suppliers.companies.destroy', [
        'supplier' => $this->supplier,
        'company' => $this->company,
    ]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Supplier removed',
            'message' => 'Supplier information has been successfully removed from respective company',
        ]);
});

/* ---------------------------- companies.update ---------------------------- */
test('user: with permission to update company', function () {
    actingAs($this->user);
    $this->user->givePermissionTo(Permission::value(UserPermission::COMPANY, 'update'));

    put(route('companies.update', $this->company), [
        'name' => 'updated company name',
        'tax_id' => '84732874837',
        'registration_number' => '98743298647234',
        'tax_value' => '25',
        'invoice_prefix' => 'INVTEST',
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Company updated',
            'message' => 'The company details have been successfully updated',
        ]);
});

/* ---------------------------- companies.destroy --------------------------- */
test('user: with permission to delete company', function () {
    actingAs($this->user);
    $this->user->givePermissionTo(Permission::value(UserPermission::COMPANY, 'delete'));

    delete(route('companies.destroy', $this->company))
        ->assertRedirectToRoute('companies.index')
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Company removed',
            'message' => 'The company has been successfully removed from your account',
        ]);
});


/* ------------------------------- USER ATTACH ------------------------------ */
test('administrator: create & attach manager', function () {
    $administrator = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $company = Company::factory()->create();
    $company->users()->attach($administrator);
    actingAs($administrator);

    post(route('users.companies.store', $company), [
        'name' => 'user',
        'email' => 'user@garage.com',
        'password' => 'P@ssword',
        'password_confirmed' => 'P@ssword',
        'active' => 'true',
        'contact' => [
            'mobile' => '7276617267',
            'email' => 'user@garage.com',
        ],
        'address' => [
            'street_number' => '321',
            'street' => 'Flower Street',
            'postcode' => '31283781',
            'country_id' => $this->country->id,
            'coordinates' => null,
        ],
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'User created & linked',
            'message' => 'User has been created and linked to company',
        ]);

    # checking user role
    $user = User::where('name', 'user')->first();
    expect($user->getRoleNames())->toMatchArray([UserRole::MANAGER->value]);
});

test('manager: create & attach user', function () {
    actingAs($this->manager);

    post(route('users.companies.store', $this->company), [
        'name' => 'user',
        'email' => 'user@garage.com',
        'password' => 'P@ssword',
        'password_confirmed' => 'P@ssword',
        'active' => 'true',
        'contact' => [
            'mobile' => '7276617267',
            'email' => 'user@garage.com',
        ],
        'address' => [
            'street_number' => '321',
            'street' => 'Flower Street',
            'postcode' => '31283781',
            'country_id' => $this->country->id,
            'coordinates' => null,
        ],
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'User created & linked',
            'message' => 'User has been created and linked to company',
        ]);

    # checking user role
    $user = User::where('name', 'user')->first();
    expect($user->getRoleNames())->toMatchArray([UserRole::USER->value]);
});

test('user: create & attach user, user should not be able to create & attach other users', function () {
    actingAs($this->user);

    post(route('users.companies.store', $this->company), [
        'name' => 'user',
        'email' => 'user@garage.com',
        'password' => 'P@ssword',
        'password_confirmed' => 'P@ssword',
        'active' => 'true',
        'contact' => [
            'mobile' => '7276617267',
            'email' => 'user@garage.com',
        ],
        'address' => [
            'street_number' => '321',
            'street' => 'Flower Street',
            'postcode' => '31283781',
            'country_id' => $this->country->id,
            'coordinates' => null,
        ],
    ])
        ->assertForbidden();

    # checking user role
    $user = User::where('name', 'user')->first();
    expect($user)->toBeNull();
});


/* ------------------------------- USER DETACH ------------------------------ */
test('administrator: remove manager', function () {
    actingAs($this->administrator);

    delete(route('users.companies.destroy', [$this->manager, $this->company]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'warning',
            'title' => 'User unlinked',
            'message' => 'User has been unlinked from company',
        ]);
});

test('administrator [detached]: cannot remove manager', function () {
    actingAs($this->administrator);

    $this->company->users()->detach($this->administrator);
    actingAs($this->administrator);

    delete(route('users.companies.destroy', [$this->manager, $this->company]))
        ->assertUnauthorized();
});

test('administrator: should remove attached users', function () {
    actingAs($this->administrator);

    delete(route('users.companies.destroy', [$this->user, $this->company]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'warning',
            'title' => 'User unlinked',
            'message' => 'User has been unlinked from company',
        ]);
});

test('administrator: cannot remove not linked manager', function () {
    actingAs($this->administrator);
    $this->administrator->managers()->detach($this->manager);

    delete(route('users.companies.destroy', [$this->manager, $this->company]))
        ->assertForbidden();
});

test('manager: remove user', function () {
    actingAs($this->manager);

    delete(route('users.companies.destroy', [$this->user, $this->company]))
        ->assertRedirect()
        ->assertSessionHas('message', (object) [
            'type' => 'warning',
            'title' => 'User unlinked',
            'message' => 'User has been unlinked from company',
        ]);
});

test('manager [detached]: cannot remove user', function () {
    $this->company->users()->detach($this->manager);
    actingAs($this->manager);

    delete(route('users.companies.destroy', [$this->user, $this->company]))
        ->assertUnauthorized();
});

test('manager: cannot remove administrator', function () {
    actingAs($this->manager);

    delete(route('users.companies.destroy', [$this->administrator, $this->company]))
        ->assertForbidden();
});

test('user: cannot remove any members', function () {
    $user2 = User::factory()->create();
    $this->company->users()->attach($user2);
    actingAs($this->user);

    delete(route('users.companies.destroy', [$user2, $this->company]))
        ->assertForbidden();
    delete(route('users.companies.destroy', [$this->manager, $this->company]))
        ->assertForbidden();
    delete(route('users.companies.destroy', [$this->administrator, $this->company]))
        ->assertForbidden();
});


/* ---------------------------- companies.restore --------------------------- */
test('user: should restore a removed company', function () {
    $this->user->givePermissionTo(Permission::value(UserPermission::COMPANY, 'restore'));
    $this->company->delete();
    actingAs($this->user);

    post(route('companies.restore', $this->company))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Company restored',
            'message' => 'The company has been successfully restored and is now available in your account',
        ]);
});

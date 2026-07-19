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
    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::USER);

    $this->company = Company::factory()->create();
    $this->contact = Contact::factory()->create();
    $this->address = Address::factory()->create(['coordinates' => null]);
    $this->supplier = Supplier::factory()->create();
    $this->user->companies()->attach($this->company);
    $this->company->contacts()->attach($this->contact);
    $this->company->addresses()->attach($this->address);
    $this->company->suppliers()->attach($this->supplier);
    $this->country = Country::factory()->create();

    actingAs($this->user);
});

test('user: should be able to see company details', function () {
    get(route('companies.edit', $this->company))
        ->assertStatus(200)
        ->assertSee($this->company->name);
});

test('user: with permission to update company', function () {
    $this->user->givePermissionTo(Permission::value(UserPermission::COMPANY, 'update'));

    put(route('companies.update', $this->company), [
        'name' => 'updated company name',
        'tax_id' => '84732874837',
        'registration_number' => '98743298647234',
        'tax_value' => '25',
        'invoice_prefix' => 'INVTEST'
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Company updated',
            'message' => 'The company details have been successfully updated'
        ]);
});

test('user: with permission to delete company', function () {
    $this->user->givePermissionTo(Permission::value(UserPermission::COMPANY, 'delete'));

    delete(route('companies.destroy', $this->company))
        ->assertRedirectToRoute('companies.index')
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Company removed',
            'message' => 'The company has been successfully removed from your account'
        ]);
});

test('user: statistics', function () {
    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'statistics'
    ]))
        ->assertStatus(200)
        ->assertSee('Data goes here');
});

test('user: members [should not be able to see attached manager & administrator]', function () {
    $administrator = User::factory()->create();
    $manager = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $manager->assignRole(UserRole::MANAGER);
    $administrator->managers()->attach($manager);
    $manager->users()->attach($this->user);
    $this->company->users()->attach([$administrator, $manager, $this->user]);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'members',
    ]))
        ->assertSee($this->user->name)
        ->assertDontSee($manager->name)
        ->assertDontSee($administrator->name);
});

test('user: contacts, see, add & remove', function () {
    $this->user->givePermissionTo([
        Permission::value(UserPermission::CONTACT, 'store'),
        Permission::value(UserPermission::CONTACT, 'delete'),
        Permission::value(UserPermission::COMPANY, 'update'),

    ]);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'contacts'
    ]))
        ->assertStatus(200);

    post(route('contacts.companies.store', $this->company), [
        'email' => 'contact@garage.com',
        'mobile' => '98291829819'
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Resource created',
            'message' => 'Contact has been created and attached to given resource'
        ]);

    delete(route('contacts.companies.destroy', [
        'contact' => $this->contact,
        'company' => $this->company
    ]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Resource removed',
            'message' => 'Contact has been removed from given resource'
        ]);
});

test('user: addresses, see, add & remove', function () {
    $this->user->givePermissionTo([
        Permission::value(UserPermission::ADDRESS, 'store'),
        Permission::value(UserPermission::ADDRESS, 'delete'),
        Permission::value(UserPermission::COMPANY, 'update'),
    ]);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'addresses'
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
            'message' => 'Address has been created and attached to given resource'
        ]);

    delete(route('addresses.companies.destroy', [
        'address' => $this->address,
        'company' => $this->company,
    ]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Resource removed',
            'message' => 'Address has been removed from given resource'
        ]);
});

test('user: supplier, see, add & remove', function () {
    $this->user->givePermissionTo([
        Permission::value(UserPermission::SUPPLIER, 'store'),
        Permission::value(UserPermission::SUPPLIER, 'delete'),
        Permission::value(UserPermission::COMPANY, 'update'),
    ]);

    get(route('companies.edit', [
        'company' => $this->company,
        'tab' => 'suppliers'
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
            'mobile' => '837287382783'
        ],
        'address' => [
            'street_number' => '123',
            'street' => 'Sunflower Street',
            'postcode' => 'B345BN',
            'country_id' => $this->country->id,
            'coordinates' => null,
        ]
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Supplier created',
            'message' => 'Supplier information has been created and attached to respective company'
        ]);

    delete(route('suppliers.companies.destroy', [
        'supplier' => $this->supplier,
        'company' => $this->company,
    ]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Supplier removed',
            'message' => 'Supplier information has been successfully removed from respective company'
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
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::MANAGER);
    $company = Company::factory()->create();
    $company->users()->attach($manager);
    actingAs($manager);

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
    expect($user->getRoleNames())->toMatchArray([UserRole::USER->value]);
});

test('user: create & attach user, user should not be able to create & attach other users', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $this->company->users()->attach($user);
    actingAs($user);

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
    $company = Company::factory()->create();
    $administrator = User::factory()->create();
    $manager = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $manager->assignRole(UserRole::MANAGER);

    $administrator->managers()->attach($manager);
    $company->users()->attach([$administrator, $manager]);
    actingAs($administrator);

    delete(route('users.companies.destroy', [$manager, $company]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'warning',
            'title' => 'User unlinked',
            'message' => 'User has been unlinked from company',
        ]);
});

test('administrator [detached]: cannot remove manager', function () {
    $company = Company::factory()->create();
    $administrator = User::factory()->create();
    $manager = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $manager->assignRole(UserRole::MANAGER);

    $company->users()->detach($administrator);
    $administrator->managers()->attach($manager);
    $company->users()->attach($manager);
    actingAs($administrator);

    delete(route('users.companies.destroy', [$manager, $company]))
        ->assertUnauthorized();
});

test('administrator: cannot remove attached users', function () {
    $company = Company::factory()->create();
    $administrator = User::factory()->create();
    $user = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $user->assignRole(UserRole::USER);

    $administrator->users()->attach($user);
    $company->users()->attach([$administrator, $user]);
    actingAs($administrator);

    delete(route('users.companies.destroy', [$user, $company]))
        ->assertForbidden();
});

test('administrator: cannot remove not linked manager', function () {
    $company = Company::factory()->create();
    $administrator = User::factory()->create();
    $manager = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $manager->assignRole(UserRole::MANAGER);

    $administrator->managers()->attach($manager);
    $company->users()->attach($administrator);
    actingAs($administrator);

    delete(route('users.companies.destroy', [$manager, $company]))
        ->assertNotFound();
});

test('manager: remove user', function () {
    $company = Company::factory()->create();
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::MANAGER);
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $manager->users()->attach($user);
    $company->users()->attach([$manager, $user]);
    actingAs($manager);

    delete(route('users.companies.destroy', [$user, $company]))
        ->assertRedirect()
        ->assertSessionHas('message', (object) [
            'type' => 'warning',
            'title' => 'User unlinked',
            'message' => 'User has been unlinked from company',
        ]);
});

test('manager [detached]: cannot remove user', function () {
    $company = Company::factory()->create();
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::MANAGER);
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $company->users()->detach($manager);
    $manager->users()->attach($user);
    $company->users()->attach($user);
    actingAs($manager);

    delete(route('users.companies.destroy', [$user, $company]))
        ->assertUnauthorized();
});

test('manager: cannot remove unauthorized/unexisting users', function () {
    $company = Company::factory()->create();
    $administrator = User::factory()->create();
    $manager = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $manager->assignRole(UserRole::MANAGER);
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);

    $manager->users()->attach($user);
    $company->users()->attach([$administrator, $manager]);
    actingAs($manager);

    delete(route('users.companies.destroy', [$user, $company]))
        ->assertNotFound();
    delete(route('users.companies.destroy', [$administrator, $company]))
        ->assertForbidden();
});

test('user: cannot remove any members', function () {
    $company = Company::factory()->create();
    $administrator = User::factory()->create();
    $manager = User::factory()->create();
    $administrator->assignRole(UserRole::ADMINISTRATOR);
    $manager->assignRole(UserRole::MANAGER);
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);

    $user2 = User::factory()->create();
    $company->users()->attach([$user, $user2, $administrator, $manager]);
    actingAs($user);

    delete(route('users.companies.destroy', [$user2, $company]))
        ->assertForbidden();
    delete(route('users.companies.destroy', [$manager, $company]))
        ->assertForbidden();
    delete(route('users.companies.destroy', [$administrator, $company]))
        ->assertForbidden();
});

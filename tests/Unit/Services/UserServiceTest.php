<?php

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\User;
use App\Services\UserService;

beforeEach(function () {
    $ext = User::factory()->createMany([
        ['name' => 'extadmin'],
        ['name' => 'extmanager'],
        ['name' => 'extuser'],
    ]);
    $ext[0]->assignRole(UserRole::ADMINISTRATOR);
    $ext[1]->assignRole(UserRole::MANAGER);
    $ext[2]->assignRole(UserRole::USER);
});

test('relation: administrator -> users', function () {
    $admin = User::factory()->create(['name' => 'admin']);
    $admin->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $admin->managers()->attach($manager);

    $users = User::factory()->createMany([
        ['name' => 'one'],
        ['name' => 'two']
    ]);
    $manager->users()->attach($users);

    $service = new UserService($admin);

    // normal model
    $users = $service
        ->model()
        ->team(UserRole::USER)
        ->get();

    // model with relational columns select & related resource
    $users = $service
        ->model()
        ->team(UserRole::USER)
        ->with('managers')
        ->select(['users.id', 'users.name'])
        ->get();

    // simple search
    $users = $service
        ->search('two')
        ->team(UserRole::USER)
        ->get();

    // search & resource filtering
    $users = $service
        ->search('two')
        ->resourceFilter(ResourceFilter::WITH_TRASHED)
        ->team(UserRole::USER)
        ->get();

    // search, filtering & pagination
    $users = $service
        ->search('two')
        ->resourceFilter(ResourceFilter::WITH_TRASHED)
        ->team(UserRole::USER)
        ->paginate(1);

    dump($users->toArray());
});

test('relation: manager -> users', function () {
    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);

    $users = User::factory(2)->create();
    $manager->users()->attach($users);

    $service = new UserService($manager);
    $users = $service->team(UserRole::USER);
    dump($users->toArray());
});

test('relation: user -> managers', function () {
    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);

    $users = User::factory(2)->create();
    $manager->users()->attach($users);
    $users[0]->assignRole(UserRole::USER);

    $service = new UserService($users[0]);
    $managers = $service->team(UserRole::MANAGER);
    dump($managers->toArray());
});

test('relation: user -> administrators', function () {
    $admin = User::factory()->create(['name' => 'admin']);
    $admin->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $admin->managers()->attach($manager);

    $users = User::factory(2)->create();
    $users[0]->assignRole(UserRole::USER);
    $manager->users()->attach($users);

    $service = new UserService($users[0]);
    $administrators = $service->team(UserRole::ADMINISTRATOR);
    dump($administrators->toArray());
});

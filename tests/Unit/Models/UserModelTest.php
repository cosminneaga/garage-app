<?php

use App\Enums\UserRole;
use App\Models\User;

test('roleRelatedUsers: ', function () {
    $admin = User::factory()->create(['name' => 'administrator']);
    $manager = User::factory()->create(['name' => 'manager']);
    $admin->assignRole(UserRole::ADMINISTRATOR->value);
    $manager->assignRole(UserRole::MANAGER->value);

    $users = User::factory()->createMany([
        ['name' => 'user1'],
        ['name' => 'user 2'],
    ]);

    $admin->roleRelatedUsers()->attach($manager);
    dd($admin->managers()->get()->toArray());
});

test('get: administrator -> users', function () {

    $admin = User::factory()->create(['name' => 'administrator']);
    $manager = User::factory()->create(['name' => 'manager']);

    $users = User::factory()->createMany([
        ['name' => 'user1'],
        ['name' => 'user 2'],
    ]);

    $admin->managers()->attach($manager);
    $manager->users()->attach($users);

    // dump($admin->managers()->get()->toArray());
    // dump($manager->users()->get()->toArray());

    $data = $admin->managers()->with('users')->get()->toArray();
    // $data = $admin->managers()->with('users')->get()->flatMap->users->unique('id')->toArray();
    // $data = $admin->managers->pluck('users')->flatten()->toArray();
    dump($data);
});

// test('get: user -> managers', function () {
//     $manager = User::factory()->create(['name' => 'manager']);

//     $users = User::factory()->createMany([
//         ['name' => 'user1'],
//         ['name' => 'user 2'],
//     ]);

//     $manager->users()->attach($users);

//     dump($users[0]->managers()->get()->toArray());
//     dump($users[1]->managers()->get()->toArray());
// });

<?php

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use App\Services\UserService;

beforeEach(function () {
    $this->admin = User::factory()->create(['name' => 'admin']);
    $this->admin2 = User::factory()->create(['name' => 'admin 2']);
    $this->admin->assignRole(UserRole::ADMINISTRATOR);
    $this->admin2->assignRole(UserRole::ADMINISTRATOR);

    $this->manager = User::factory()->create(['name' => 'manager']);
    $this->manager2 = User::factory()->create(['name' => 'manager 2']);
    $this->manager->assignRole(UserRole::MANAGER);
    $this->manager2->assignRole(UserRole::MANAGER);
    $this->admin->managers()->attach([$this->manager, $this->manager2]);

    $this->user = User::factory()->create(['name' => 'user']);
    $this->user2 = User::factory()->create(['name' => 'user 2']);
    $this->user->assignRole(UserRole::USER);
    $this->user2->assignRole(UserRole::USER);
    $this->manager->users()->attach([$this->user, $this->user2]);

    $this->extUsers = User::factory()->createMany([
        ['name' => 'extadmin'],
        ['name' => 'extmanager'],
        ['name' => 'extuser'],
    ]);
    $this->extUsers[0]->assignRole(UserRole::ADMINISTRATOR);
    $this->extUsers[1]->assignRole(UserRole::MANAGER);
    $this->extUsers[2]->assignRole(UserRole::USER);
});

test('resourceFilter: filter resources based on given filter', function () {
    $service = new UserService($this->admin);
    $users = $service->model()->resourceFilter()->get();
    expect($users)->toHaveCount(9);

    $this->user->delete();
    $users = $service->model()->resourceFilter()->get();
    expect($users)->toHaveCount(8);

    $users = $service->model()->resourceFilter(ResourceFilter::WITH_TRASHED)->get();
    expect($users)->toHaveCount(9);

    $users = $service->model()->resourceFilter(ResourceFilter::ONLY_TRASHED)->get();
    expect($users)->toHaveCount(1);
});

/* ------------------------------ 3 layers ----------------------------- */
/* ------------------------------ TOP -> BOTTOM ----------------------------- */
test('team: administrator -> users', function () {
    $service = new UserService($this->admin);
    $users = $service
        ->model()
        ->team(UserRole::USER)
        ->orderBy('id')
        ->get();

    expect($users)->toHaveCount(2);
    expect($users[0])->toMatchArray([
        'name' => 'user',
    ]);
});
/* ------------------------------ BOTTOM -> UP ------------------------------ */
test('team: user -> administrators', function () {
    $service = new UserService($this->user);
    $users = $service
        ->model()
        ->team(UserRole::ADMINISTRATOR)
        ->orderBy('id')
        ->get();

    expect($users)->toHaveCount(1);
    expect($users[0])->toMatchArray([
        'name' => 'admin',
    ]);
});

/* -------------------------------- 2 layers -------------------------------- */
/* ------------------------------ TOP -> BOTTOM ----------------------------- */
test('team: administrator -> managers', function () {
    $service = new UserService($this->admin);
    $users = $service
        ->model()
        ->team(UserRole::MANAGER)
        ->orderBy('id')
        ->get();

    expect($users)->toHaveCount(2);
    expect($users[0])->toMatchArray([
        'name' => 'manager',
    ]);
});

test('team: manager -> users', function () {
    $service = new UserService($this->manager);
    $users = $service
        ->model()
        ->team(UserRole::USER)
        ->orderBy('id')
        ->get();

    expect($users)->toHaveCount(2);
    expect($users[0])->toMatchArray([
        'name' => 'user',
    ]);
});

/* ------------------------------ BOTTOM -> UP ------------------------------ */
test('team: manager -> administrators', function () {
    $service = new UserService($this->manager);
    $users = $service
        ->model()
        ->team(UserRole::ADMINISTRATOR)
        ->orderBy('id')
        ->get();

    expect($users)->toHaveCount(1);
    expect($users[0])->toMatchArray([
        'name' => 'admin',
    ]);
});

test('search on team: administrator -> managers', function () {
    $service = new UserService($this->admin);
    $result = $service
        ->search()
        ->team(UserRole::MANAGER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(2);
    expect($result[0]->getAttributes())->toMatchArray($this->manager->getAttributes());
    expect($result[1]->getAttributes())->toMatchArray($this->manager2->getAttributes());
});

test('search on team: administrator -> users', function () {
    $service = new UserService($this->admin);
    $result = $service
        ->search()
        ->team(UserRole::USER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(2);
    expect($result[0]->getAttributes())->toMatchArray($this->user->getAttributes());
    expect($result[1]->getAttributes())->toMatchArray($this->user2->getAttributes());
});

test('search on team: administrator -> should not find "manager" that is not part of the team', function () {
    $service = new UserService($this->admin);
    $result = $service
        ->search('extmanager')
        ->team(UserRole::MANAGER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(0);
});

test('search on team: administrator -> should not find "user" that is not part of the team', function () {
    $service = new UserService($this->admin);
    $result = $service
        ->search('extuser')
        ->team(UserRole::USER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(0);
});

test('search on team: manager -> administrators', function () {
    $service = new UserService($this->manager);
    $result = $service
        ->search()
        ->team(UserRole::ADMINISTRATOR)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(1);
    expect($result[0]->getAttributes())->toMatchArray($this->admin->getAttributes());
});

test('search on team: manager -> users', function () {
    $service = new UserService($this->manager);
    $result = $service
        ->search()
        ->team(UserRole::USER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(2);
    expect($result[0]->getAttributes())->toMatchArray($this->user->getAttributes());
    expect($result[1]->getAttributes())->toMatchArray($this->user2->getAttributes());
});

test('search on team: manager -> should not find "administrator" that didn\'t attached this "manager"', function () {
    $service = new UserService($this->manager);
    $result = $service
        ->search('admin no role')
        ->team(UserRole::ADMINISTRATOR)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(0);
});

test('search on team: manager -> should not find "user" that is not part of the team', function () {
    $service = new UserService($this->manager);
    $result = $service
        ->search('extuser')
        ->team(UserRole::USER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(0);
});

test('search on team: user -> managers', function () {
    $service = new UserService($this->user);
    $result = $service
        ->search()
        ->team(UserRole::MANAGER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(1);
    expect($result[0]->getAttributes())->toMatchArray($this->manager->getAttributes());
});

test('search on team: user -> administrators', function () {
    $service = new UserService($this->user);
    $result = $service
        ->search()
        ->team(UserRole::ADMINISTRATOR)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(1);
    expect($result[0]->getAttributes())->toMatchArray($this->admin->getAttributes());
});

test('search on team: user -> should not find "manager" that didn\'t attached this "user"', function () {
    $service = new UserService($this->user);
    $result = $service
        ->search('manager 2')
        ->team(UserRole::MANAGER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(0);
});

test('search on team: user -> should not find "manager" that is not part of the team', function () {
    $service = new UserService($this->user);
    $result = $service
        ->search('manager 2')
        ->team(UserRole::MANAGER)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(0);
});

test('search on team: user -> should not find "administrator" that doesn\'t have common "manager"', function () {
    $service = new UserService($this->user);
    $result = $service
        ->search('admin 2')
        ->team(UserRole::ADMINISTRATOR)
        ->orderBy('users.id')
        ->get();

    expect($result)->toHaveCount(0);
});

test('whereIn: all users attached to company', function () {
    $service = new UserService($this->admin);

    $company = Company::factory()->create();
    $user = User::factory()->create();
    $company->users()->attach($user);

    $members = $service->model()->whereIn($company)->get();

    expect($members)->toHaveCount(1);
    expect($members[0]->id)->toEqual($user->id);
});

test('whereNotIn: all users not attached to company', function () {
    $service = new UserService($this->admin);

    $company = Company::factory()->create();
    $user = User::factory()->create();
    $company->users()->attach($user);

    $nonMembers = $service->model()->whereNotIn($company)->get();

    expect($nonMembers)->toHaveCount(9);
});

test('whereIn: filter own attached to company', function () {
    $service = new UserService($this->admin);

    $company = Company::factory()->create();
    $user = User::factory()->create();
    $company->users()->attach($user);
    $company->users()->attach($this->manager);

    $members = $service->model()->team(UserRole::MANAGER)->whereIn($company)->get();

    expect($members)->toHaveCount(1);
    expect($members[0]->id)->toEqual($this->manager->id);
});

test('whereNotIn: filter own not attached to company', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::MANAGER);
    $service = new UserService($manager);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $company = Company::factory()->create();
    $company->users()->attach($user);
    // $company->users()->attach($manager);

    $nonMemberUser = User::factory()->create();
    $nonMemberUser->assignRole(UserRole::USER);

    $manager->users()->attach([$user, $nonMemberUser]);


    $nonMembers = $service->model()->team(UserRole::USER)->whereNotIn($company)->get();

    expect($nonMembers)->toHaveCount(1);
    expect($nonMembers[0]->id)->toEqual($nonMemberUser->id);
});

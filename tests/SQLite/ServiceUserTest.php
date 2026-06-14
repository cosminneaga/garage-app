<?php

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\User;
use App\Services\UserService;

beforeEach(function () {
    $this->admin = User::factory()->create(['name' => 'admin']);
    $this->adminNoRole = User::factory()->create(['name' => 'admin no role']);
    $this->admin->assignRole(UserRole::ADMINISTRATOR);

    $this->manager = User::factory()->create(['name' => 'manager']);
    $this->managerNoRole = User::factory()->create(['name' => 'manager no role']);
    $this->manager->assignRole(UserRole::MANAGER);
    $this->admin->managers()->attach([$this->manager, $this->managerNoRole]);

    $this->user = User::factory()->create(['name' => 'user']);
    $this->userNoRole = User::factory()->create(['name' => 'user no role']);
    $this->user->assignRole(UserRole::USER);
    $this->manager->users()->attach([$this->user, $this->userNoRole]);

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

test('team: administrator -> users', function () {
    $service = new UserService($this->admin);
    $users = $service
        ->model()
        ->team(UserRole::USER)
        ->get();

    expect($users)->toHaveCount(2);
    expect($users[0])->toMatchArray([
        'name' => 'user'
    ]);
});

/**
 * !!!FIX:
 * if there is a manager attached but has no users attached to it, this will not be visible on current query
 *
 * select distinct "users".* from "users"
 * inner join "team_manager_users" on "team_manager_users"."manager_id" = "users"."id"
 * inner join "team_administrator_managers" on "team_administrator_managers"."manager_id" = "team_manager_users"."manager_id"
 * where "team_administrator_managers"."administrator_id" = ?
 * and "users"."deleted_at" is null order by "id" asc
 *
 * instead the query should be build as so:
 *
 * select distinct "users".* from "users"
 * inner join "team_administrator_managers" on "team_administrator_managers"."manager_id" = "users"."id"
 * where "team_administrator_managers"."administrator_id" = ?
 * and "users"."deleted_at" is null order by "id" asc
 *
 * when 1-1 proximity we should not go for the next table
 */
test('team: administrator -> managers', function () {
    $service = new UserService($this->admin);
    $users = $service
        ->model()
        ->team(UserRole::MANAGER)
        ->get();

    expect($users)->toHaveCount(2);
    expect($users[0])->toMatchArray([
        'name' => 'manager'
    ]);
});

test('team: manager -> administrators', function () {
    $service = new UserService($this->manager);
    $users = $service
        ->model()
        ->team(UserRole::ADMINISTRATOR)
        ->get();

    expect($users)->toHaveCount(1);
    expect($users[0])->toMatchArray([
        'name' => 'admin'
    ]);
});

/**
 * select distinct "users".* from "users"
 * where "team_manager_users"."manager_id" = 3
 * and "users"."deleted_at" is null order by "id" asc
 */
test('team: manager -> users', function () {
    $service = new UserService($this->manager);
    $users = $service
        ->model()
        ->team(UserRole::USER)
        ->get();

    expect($users)->toHaveCount(2);
    expect($users[0])->toMatchArray([
        'name' => 'user'
    ]);
});

/**
 * select distinct "users".* from "users"
 * inner join "team_manager_users" on "team_manager_users"."user_id" = "users"."id"
 * inner join "team_administrator_managers" on "team_administrator_managers"."manager_id" = "team_manager_users"."manager_id"
 * where "team_administrator_managers"."manager_id" = ?
 * and "users"."deleted_at" is null order by "id" asc
 *
 * when going from bottom to up direction on more than 2 table points, everything goes down
 * as we don't reverse the tables anymore the pointer does not know where to point
 *
 * Illuminate\Support\Collection^ {#4323
 * //   #items: [
 * //     0 => {
 * //       +"table_name": "team_administrator_managers"
 * //       +"columns": [
 * //         0 => {
 * //           +"type": "fk"
 * //           +"value": "manager_id"
 * //         }
 * //         1 => {
 * //           +"type": "pk"
 * //           +"value": "administrator_id"
 * //         }
 * //       ]
 * //     }
 * //     1 => {
 * //       +"table_name": "team_manager_users"
 * //       +"columns": [
 * //         0 => {#6069
 * //           +"type": "pk"
 * //           +"value": "manager_id"
 * //         }
 * //         1 => {
 * //           +"type": "fk"
 * //           +"value": "user_id"
 * //         }
 * //       ]
 * //     }
 * //     2 => {
 * //       +"table_name": "team_manager_users"
 * //       +"columns": [
 * //         0 => {
 * //           +"type": "fk"
 * //           +"value": "manager_id"
 * //         }
 * //         1 => {
 * //           +"type": "pk"
 * //           +"value": "user_id"
 * //         }
 * //       ]
 * //     }
 * //   ]
 * //   #escapeWhenCastingToString: false
 * // }
 */
test('team: user -> administrators', function (): never {
    $service = new UserService($this->user);
    $users = $service
        ->model()
        ->team(UserRole::ADMINISTRATOR)
        ->dd();
    dd($users->toArray());
    expect($users)->toHaveCount(1);
    expect($users[0])->toMatchArray([
        'name' => 'admin'
    ]);
});

test('search on team: administrator -> finding manager with given role', function (): never {
    $service = new UserService($this->admin);
    $result = $service->search()->team(UserRole::MANAGER)->get();
    dd($result->toArray());
    expect($result)->toHaveCount(1);
    expect($result[0]->getAttributes())->toMatchArray($this->manager->getAttributes());
});

test('search on team: administrator -> should not find manager with no role', function () {
    $service = new UserService($this->admin);
    $result = $service->search('manager no role')->team(UserRole::MANAGER)->get();

    expect($result)->toHaveCount(0);
});

test('search on team: administrator -> should not find manager that is not part of the team', function () {
    $service = new UserService($this->admin);
    $result = $service->search('extmanager')->team(UserRole::MANAGER)->get();

    expect($result)->toHaveCount(0);
});

test('search on team: manager -> administrator', function () {
    $service = new UserService($this->manager);
    $result = $service->search('admin')->team(UserRole::ADMINISTRATOR)->get();

    expect($result)->toHaveCount(1);
    expect($result[0]->getAttributes())->toMatchArray($this->admin->getAttributes());
});

test('search on team: manager -> user', function () {
    $service = new UserService($this->manager);
    $result = $service->search()->team(UserRole::USER)->get();

    dump($result->toArray());
    expect($result)->toHaveCount(1);
    expect($result[0]->getAttributes())->toMatchArray($this->user->getAttributes());
});

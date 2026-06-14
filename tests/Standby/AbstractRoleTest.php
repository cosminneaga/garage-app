<?php

use App\Enums\UserRole;
use App\Models\User;
use App\Services\UserService;

test('example test', function () {
    $users = User::factory()->createMany([
        ['name' => 'administrator'],
        ['name' => 'manager'],
        ['name' => 'user']
    ]);

    $users2 = User::factory()->createMany([
        ['name' => 'administrator2'],
        ['name' => 'manager2'],
        ['name' => 'user2']
    ]);

    $users[0]->assignRole(UserRole::ADMINISTRATOR);
    $users[1]->assignRole(UserRole::MANAGER);
    $users[2]->assignRole(UserRole::USER);
    $users[0]->managers()->attach($users[1]);
    $users[1]->users()->attach($users[2]);

    $users2[0]->assignRole(UserRole::ADMINISTRATOR);
    $users2[1]->assignRole(UserRole::MANAGER);
    $users2[2]->assignRole(UserRole::USER);
    $users2[0]->managers()->attach($users2[1]);
    $users2[1]->users()->attach($users2[2]);

    /* ------------------------------ ADMINISTRATOR ----------------------------- */
    $service = new UserService($users[0]);

    // managers
    /**
     * select distinct * from "users"
     * inner join "team_manager_users" on "team_manager_users"."manager_id" = "users"."id"
     * inner join "team_administrator_managers" on "team_administrator_managers"."manager_id" = "team_manager_users"."manager_id"
     * where "team_administrator_managers"."administrator_id" = ?
     * and "users"."deleted_at" is null
     */
    $result = $service->model()->team(UserRole::MANAGER)->get();
    dump('ADMINISTRATOR -> MANAGERS', $result->toArray());

    // users
    /**
     * select distinct * from "users"
     * inner join "team_manager_users" on "team_manager_users"."user_id" = "users"."id"
     * inner join "team_administrator_managers" on "team_administrator_managers"."manager_id" = "team_manager_users"."manager_id"
     * where "team_administrator_managers"."administrator_id" = ?
     * and "users"."deleted_at" is null
     */
    $result = $service->model()->team(UserRole::USER)->get();
    dump('ADMINISTRATOR -> USERS', $result->toArray());


    /* --------------------------------- MANAGER -------------------------------- */
    $service = new UserService($users[1]);

    // users
    /**
     * select distinct * from "users"
     * inner join "team_manager_users" on "team_manager_users"."manager_id" = "users"."id"
     * inner join "team_administrator_managers" on "team_administrator_managers"."manager_id" = "team_manager_users"."manager_id"
     * where "team_administrator_managers"."administrator_id" = ?
     * and "users"."deleted_at" is null
     */
    $result = $service->model()->team(UserRole::USER)->get();
    dump('MANAGER -> USERS', $result->toArray());

    // administrators
    /**
     * select distinct * from "users"
     * inner join "team_administrator_managers" on "team_administrator_managers"."administrator_id" = "users"."id"
     * inner join "team_manager_users" on "team_manager_users"."manager_id" = "team_administrator_managers"."manager_id"
     * where "team_manager_users"."manager_id" = ?
     * and "users"."deleted_at" is null
     */
    $result = $service->model()->team(UserRole::ADMINISTRATOR)->get();
    dump('MANAGER -> ADMINISTRATORS', $result->toArray());


    /* ---------------------------------- USER ---------------------------------- */
    $service = new UserService($users[2]);

    // managers
    $result = $service->model()->team(UserRole::MANAGER)->get();
    dump('USER -> MANAGERS', $result->toArray());

    // administrators
    /**
     * select distinct * from "users"
     * inner join "team_administrator_managers" on "team_administrator_managers"."administrator_id" = "users"."id"
     * inner join "team_manager_users" on "team_manager_users"."manager_id" = "team_administrator_managers"."manager_id"
     * where "team_manager_users"."user_id" = ?
     * and "users"."deleted_at" is null
     */
    $result = $service->model()->team(UserRole::ADMINISTRATOR)->get();
    dump('USER -> ADMINISTRATORS', $result->toArray());

});

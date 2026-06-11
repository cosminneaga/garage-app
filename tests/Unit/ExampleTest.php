<?php

use App\Enums\NewUserRole;
use App\Models\User;
use Illuminate\Support\Collection;

test('example test', function () {
    $users = User::factory()->createMany([
        ['name' => 'ceo'],
        ['name' => 'administrator'],
        ['name' => 'manager'],
        ['name' => 'user']
    ]);

    $users2 = User::factory()->createMany([
        ['name' => 'ceo2'],
        ['name' => 'administrator2'],
        ['name' => 'manager2'],
        ['name' => 'user2']
    ]);

    $users[0]->assignRole('ceo');
    $users[1]->assignRole('administrator');
    $users[2]->assignRole('manager');
    $users[3]->assignRole('user');
    $users[0]->relatedUsers()->attach($users[1]);
    $users[1]->relatedUsers()->attach($users[2]);
    $users[2]->relatedUsers()->attach($users[3]);

    $users2[0]->assignRole('ceo');
    $users2[1]->assignRole('administrator');
    $users2[2]->assignRole('manager');
    $users2[3]->assignRole('user');
    $users2[0]->relatedUsers()->attach($users2[1]);
    $users2[1]->relatedUsers()->attach($users2[2]);
    $users2[2]->relatedUsers()->attach($users2[3]);

    // dump($users[2]->relatedUsers()->get()[0]->getAttributes());

    // $relations = NewUserRole::mapRelation(NewUserRole::CEO, NewUserRole::ADMINISTRATOR);
    // dd($relations);

    $users[1]->deepThroughRoles(NewUserRole::CEO);

    /* ----------------------------------- CEO ---------------------------------- */
    // ceo -> administrators (1-1 proximity)
    $result = $users[0]
        ->join('team_ceo', 'team_ceo.administrator_id', '=', 'users.id')
        ->where('team_ceo.ceo_id', $users[0]->id);

    // ceo -> managers
    $result = $users[0]
        ->join('team_manager', 'team_manager.manager_id', '=', 'users.id')
        ->join('team_ceo', 'team_ceo.administrator_id', '=', 'team_administrator.administrator_id')
        ->join('team_administrator', 'team_administrator.manager_id', '=', 'team_manager.manager_id')
        ->where('team_ceo.ceo_id', $users[0]->id);

    // ceo -> users
    $result = $users[0]
        ->join('team_manager', 'team_manager.user_id', '=', 'users.id')
        ->join('team_ceo', 'team_ceo.administrator_id', '=', 'team_administrator.administrator_id')
        ->join('team_administrator', 'team_administrator.manager_id', '=', 'team_manager.manager_id')
        ->where('team_ceo.ceo_id', $users[0]->id);


    /* ------------------------------ ADMINISTRATOR ----------------------------- */
    // administrator -> managers (1-1 proximity)
    $result = $users[1]
        ->join('team_administrator', 'team_administrator.manager_id', '=', 'users.id')
        ->where('team_administrator.administrator_id', $users[1]->id);

    // administrator -> users
    $result = $users[1]
        ->join('team_manager', 'team_manager.user_id', '=', 'users.id')
        ->join('team_administrator', 'team_administrator.manager_id', '=', 'team_manager.manager_id')
        ->where('team_administrator.administrator_id', $users[1]->id);

    // administrator -> ceos (1-1 proximity)
    // $result = $users[1]
    //     ->join('team_ceo', 'team_ceo.ceo_id', '=', 'users.id')
    //     ->where('team_ceo.administrator_id', $users[1]->id);
    $result = $users[1]
        ->join('team_ceo', 'team_ceo.ceo_id', '=', 'users.id')
        ->join('team_administrator', 'team_administrator.administrator_id', '=', 'team_ceo.administrator_id')
        ->where('team_administrator.administrator_id', $users[1]->id);


    // /* --------------------------------- MANAGER -------------------------------- */
    // manager -> users (1-1 proximity)
    // $result = $users[2]
    //     ->join('team_manager', 'team_manager.user_id', '=', 'users.id')
    //     ->where('team_manager.manager_id', $users[2]->id);

    // // manager -> administrators (1-1 proximity)
    // $result = $users[2]
    //     ->join('team_administrator', 'team_administrator.administrator_id', '=', 'users.id')
    //     ->where('team_administrator.manager_id', $users[2]->id);

    // // manager -> ceos
    // $result = $users[2]
    //     ->join('team_ceo', 'team_ceo.ceo_id', '=', 'users.id')
    //     ->join('team_manager', 'team_manager.manager_id', '=', 'team_administrator.manager_id')
    //     ->join('team_administrator', 'team_administrator.administrator_id', '=', 'team_ceo.administrator_id')
    //     ->where('team_manager.manager_id', $users[2]->id);


    // /* ---------------------------------- USERS --------------------------------- */
    // // user -> manager (1-1 proximity)
    // $result = $users[3]
    //     ->join('team_manager', 'team_manager.manager_id', '=', 'users.id')
    //     ->where('team_manager.user_id', $users[3]->id);

    // // user -> administrators
    // $result = $users[3]
    //     ->join('team_administrator', 'team_administrator.administrator_id', '=', 'users.id')
    //     ->join('team_manager', 'team_manager.manager_id', '=', 'team_administrator.manager_id')
    //     ->where('team_manager.user_id', $users[3]->id);

    // // user -> ceos
    // $result = $users[3]
    //     ->join('team_ceo', 'team_ceo.ceo_id', '=', 'users.id')
    //     ->join('team_manager', 'team_manager.manager_id', '=', 'team_administrator.manager_id')
    //     ->join('team_administrator', 'team_administrator.administrator_id', '=', 'team_ceo.administrator_id')
    //     ->where('team_manager.user_id', $users[3]->id);


    $result = $result->select('users.*')
        ->distinct()
        ->get();

    /**
     * 1. join but db users point
     * 2 or others. inner joins
     * 3. where condition
     */

    dump(new Collection($result)->toArray());

    /**
     * ceo -> administrators
     * $this->join('team_ceo', 'team_ceo.ceo_id', '=', 'users.id')
     *  ->where('team_ceo', 'team_ceo.administrator_id', '=', $this->id)
     */


});

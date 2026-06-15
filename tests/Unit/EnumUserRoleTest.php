<?php

declare(strict_types=1);

use App\Enums\UserRole;

test('label: get specific role label', function () {
    expect(UserRole::SUPER->label())->toEqual('Application Administrator');
    expect(UserRole::ADMINISTRATOR->label())->toEqual('Companies Administrator');
    expect(UserRole::MANAGER->label())->toEqual('Specific companies administrator & manager');
    expect(UserRole::USER->label())->toEqual('Tipical user');
});

test('relation: get specific resource info', function () {
    $administrator = UserRole::relation(UserRole::ADMINISTRATOR);
    $manager = UserRole::relation(UserRole::MANAGER);
    $user = UserRole::relation(UserRole::USER);

    expect($administrator)->toMatchArray([
        'table_name' => 'team_administrator_managers',
        'columns' => [
            (object) ['type' => 'pk', 'value' => 'administrator_id'],
            (object) ['type' => 'fk', 'value' => 'manager_id']
        ],
    ]);
    expect($manager)->toMatchArray([
        'table_name' => 'team_manager_users',
        'columns' => [
            (object) ['type' => 'pk', 'value' => 'manager_id'],
            (object) ['type' => 'fk', 'value' => 'user_id']
        ],
    ]);
    expect($user)->toMatchArray([
        'table_name' => 'team_manager_users',
        'columns' => [
            (object) ['type' => 'pk', 'value' => 'user_id'],
            (object) ['type' => 'fk', 'value' => 'manager_id']
        ],
    ]);
});

test('mapRelation: Administrator -> Users', function () {
    $result = UserRole::mapRelation(UserRole::ADMINISTRATOR, UserRole::USER);

    expect($result)->toEqual(collect([
        (object) [
            'table_name' => 'team_administrator_managers',
            'columns' => [
                (object) ['type' => 'pk', 'value' => 'administrator_id'],
                (object) ['type' => 'fk', 'value' => 'manager_id']
            ],
        ],
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'pk', 'value' => 'manager_id'],
                (object) ['type' => 'fk', 'value' => 'user_id']
            ],
        ],
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'pk', 'value' => 'user_id'],
                (object) ['type' => 'fk', 'value' => 'manager_id']
            ],
        ]
    ]));
});

test('mapRelation: Administrator -> Managers', function () {
    $result = UserRole::mapRelation(UserRole::ADMINISTRATOR, UserRole::MANAGER);

    expect($result)->toEqual(collect([
        (object) [
            'table_name' => 'team_administrator_managers',
            'columns' => [
                (object) ['type' => 'pk', 'value' => 'administrator_id'],
                (object) ['type' => 'fk', 'value' => 'manager_id']
            ],
        ],
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'pk', 'value' => 'manager_id'],
                (object) ['type' => 'fk', 'value' => 'user_id']
            ],
        ],
    ]));
});

test('mapRelation: User -> Administrators', function () {
    $result = UserRole::mapRelation(UserRole::USER, UserRole::ADMINISTRATOR);

    expect($result)->toEqual(collect([
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'fk', 'value' => 'manager_id'],
                (object) ['type' => 'pk', 'value' => 'user_id'],
            ],
        ],
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'pk', 'value' => 'manager_id'],
                (object) ['type' => 'fk', 'value' => 'user_id']
            ],
        ],
        (object) [
            'table_name' => 'team_administrator_managers',
            'columns' => [
                (object) ['type' => 'fk', 'value' => 'manager_id'],
                (object) ['type' => 'pk', 'value' => 'administrator_id'],
            ],
        ],
    ]));
});

test('mapRelation: User -> Managers', function () {
    $result = UserRole::mapRelation(UserRole::USER, UserRole::MANAGER);

    expect($result)->toEqual(collect([
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'fk', 'value' => 'user_id'],
                (object) ['type' => 'pk', 'value' => 'manager_id'],
            ],
        ],
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'fk', 'value' => 'manager_id'],
                (object) ['type' => 'pk', 'value' => 'user_id'],
            ],
        ],
    ]));
});

test('mapRelation: Manager -> Users', function () {
    $result = UserRole::mapRelation(UserRole::MANAGER, UserRole::USER);

    expect($result)->toEqual(collect([
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'pk', 'value' => 'manager_id'],
                (object) ['type' => 'fk', 'value' => 'user_id']
            ],
        ],
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'pk', 'value' => 'user_id'],
                (object) ['type' => 'fk', 'value' => 'manager_id']
            ],
        ],
    ]));
});

test('mapRelation: Manager -> Administrators', function () {
    $result = UserRole::mapRelation(UserRole::MANAGER, UserRole::ADMINISTRATOR);

    expect($result)->toEqual(collect([
        (object) [
            'table_name' => 'team_administrator_managers',
            'columns' => [
                (object) ['type' => 'fk', 'value' => 'manager_id'],
                (object) ['type' => 'pk', 'value' => 'administrator_id'],
            ],
        ],
        (object) [
            'table_name' => 'team_manager_users',
            'columns' => [
                (object) ['type' => 'fk', 'value' => 'user_id'],
                (object) ['type' => 'pk', 'value' => 'manager_id'],
            ],
        ],
    ]));
});

test('values: get cases values', function () {
    expect(UserRole::values())->toMatchArray([
        'super',
        'administrator',
        'manager',
        'user'
    ]);
});

test('ui: get enum data', function () {
    expect(UserRole::ui())->toMatchArray([
        [
            'value' => 'administrator',
            'label' => 'Companies Administrator',
        ],
        [
            'value' => 'manager',
            'label' => 'Specific companies administrator & manager',
        ],
        [
            'value' => 'user',
            'label' => 'Tipical user',
        ],
    ]);
});

test('findByValue: get specific role by it\'s value', function () {
    expect(UserRole::findByValue('administrator'))->toEqual(UserRole::ADMINISTRATOR);
    expect(UserRole::findByValue('manager'))->toEqual(UserRole::MANAGER);
    expect(UserRole::findByValue('user'))->toEqual(UserRole::USER);
    expect(UserRole::findByValue('wrong'))->toEqual(null);
});

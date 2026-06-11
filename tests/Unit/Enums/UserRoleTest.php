<?php

use App\Enums\UserRole;

test('mapRelation: Administrator -> Users', function () {
    $result = UserRole::mapRelation(UserRole::ADMINISTRATOR, UserRole::USER);

    dump($result);
});

test('mapRelation: Administrator -> Managers', function () {
    $result = UserRole::mapRelation(UserRole::ADMINISTRATOR, UserRole::MANAGER);

    dump($result);
});

test('mapRelation: User -> Administrators', function () {
    $result = UserRole::mapRelation(UserRole::USER, UserRole::ADMINISTRATOR);

    dump($result);
});

test('mapRelation: User -> Managers', function () {
    $result = UserRole::mapRelation(UserRole::USER, UserRole::MANAGER);

    dump($result);
});

test('mapRelation: Manager -> Users', function () {
    $result = UserRole::mapRelation(UserRole::MANAGER, UserRole::USER);

    dump($result);
});

test('mapRelation: Manager -> Administrators', function () {
    $result = UserRole::mapRelation(UserRole::MANAGER, UserRole::ADMINISTRATOR);

    dump($result);
});

<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use App\Services\CompanyService;

test('testing', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_ADMIN->value);

    $resources = Company::factory(10)->create();
    collect($resources)->map(function ($comp, $index) use ($user) {
        $comp->name = 'DEFAULT ' . $index;
        $comp->update();
        $comp->users()->attach($user);
    });

    $nonAlocattedResources = Company::factory(5)->create(['name' => 'DELETED']);
    collect($nonAlocattedResources)->map(function ($comp) use ($user) {
        $comp->users()->attach($user);
        $comp->delete($comp);
    });

    $editor = User::factory()->create();
    $editor->assignRole(UserRole::USER_EDITOR->value);
    $user->team()->attach($editor);
    $service = new CompanyService($editor);

    dump($service->search('')->filterOwn(ResourceFilter::DEFAULT)->get()->pluck('name'));
});

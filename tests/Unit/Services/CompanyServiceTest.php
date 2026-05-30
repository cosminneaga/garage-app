<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use App\Services\CompanyService;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->admin->assignRole(UserRole::USER_ADMIN->value);

    $this->editor = User::factory()->create();
    $this->editor->assignRole(UserRole::USER_EDITOR->value);
    $this->admin->team()->attach($this->editor);

    $this->adminCompanyService = new CompanyService($this->admin);
});

test('should be properly filtered using resource filter enum', function () {
    $user = $this->admin;

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

    expect($this->adminCompanyService->search('')->filterOwn(ResourceFilter::DEFAULT)->get())->toHaveCount(10);
    expect($this->adminCompanyService->search('')->filterOwn(ResourceFilter::ONLY_TRASHED)->get())->toHaveCount(5);
    expect($this->adminCompanyService->search('')->filterOwn(ResourceFilter::WITH_TRASHED)->get())->toHaveCount(15);
});

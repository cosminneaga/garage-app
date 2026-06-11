<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->editor = User::factory()->create();
    $this->viewer = User::factory()->create();
    $this->admin->assignRole(UserRole::USER_ADMIN->value);
    $this->editor->assignRole(UserRole::USER_EDITOR->value);
    $this->viewer->assignRole(UserRole::USER_VIEWER->value);

    $this->admin->team()->attach([$this->editor, $this->viewer]);

    $this->company = Company::factory()->create();
    $this->admin->companies()->attach($this->company);
});

test('should pass if company belongs to admin, and users are attached to company', function () {
    $this->company->users()->attach([$this->editor, $this->viewer]);

    expect($this->company->isMyCompany($this->admin))->toBeTrue();
    expect($this->company->isMyCompany($this->editor))->toBeTrue();
    expect($this->company->isMyCompany($this->viewer))->toBeTrue();
});

test('should fail if company belongs to admin, but not linked to users', function () {
    expect($this->company->isMyCompany($this->editor))->toBeFalse();
    expect($this->company->isMyCompany($this->viewer))->toBeFalse();
});

test('should fail if user has no role assigned', function () {
    $this->editor->removeRole(UserRole::USER_EDITOR->value);

    expect($this->company->isMyCompany($this->editor))->toBeFalse();
});

test('should fail if user has no manager, even if is linked to respective company', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();

    $user->assignRole(UserRole::USER_EDITOR->value);
    $user->companies()->attach($company);

    expect($this->company->isMyCompany($this->editor))->toBeFalse();
});

test('should fail if user is not part of admin team, even if is linked to respective company', function () {
    $this->company->users()->attach($this->editor);
    $this->admin->team()->delete($this->editor);

    expect($this->company->isMyCompany($this->editor))->toBeFalse();
});

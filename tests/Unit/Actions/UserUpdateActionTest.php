<?php

declare(strict_types=1);

use App\Actions\UserUpdateAction;
use App\Enums\UserRole;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->admin->assignRole(UserRole::USER_ADMIN->value);

    $this->country = Country::factory()->create();
    $this->file = UploadedFile::fake()->image('avatar.jpg');

    $this->action = new UserUpdateAction();

    $this->user = User::factory()->create();
});

test('should update user', function () {
    $this->action->handle([
        'name' => 'Updated USER',
        'email' => 'updateduser@garage.com',
        'image' => $this->file,
        'role' => UserRole::USER_VIEWER->value,
        'active' => true,
    ], $this->user);

    expect($this->user)->toMatchArray([
        'name' => 'Updated USER',
        'email' => 'updateduser@garage.com',
        'active' => true,
    ]);
});

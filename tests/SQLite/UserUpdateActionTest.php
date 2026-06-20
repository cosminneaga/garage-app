<?php

declare(strict_types=1);

use App\Actions\UserUpdateAction;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->file = UploadedFile::fake()->image('avatar.jpg');

    $this->action = new UserUpdateAction();
    $this->user = User::factory()->create();
});

test('should update user', function () {
    actingAs($this->administrator);
    $this->action->handle([
        'name' => 'Updated USER',
        'email' => 'updateduser@garage.com',
        'image' => $this->file,
        'role' => UserRole::USER->value,
        'active' => true,
    ], $this->user);

    expect($this->user)->toMatchArray([
        'name' => 'Updated USER',
        'email' => 'updateduser@garage.com',
        'active' => true,
        'updated_by' => $this->administrator->id,
    ]);
});

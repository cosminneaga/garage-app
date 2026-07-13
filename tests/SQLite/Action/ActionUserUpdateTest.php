<?php

use App\Actions\UserUpdateAction;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    $this->country = Country::factory()->create();
    $file = UploadedFile::fake()->image('avatar.jpg');
    $this->user = User::factory()->create([
        'name' => 'User Init',
        'email' => 'test@garage.com',
        'active' => true,
        'image_path' => 'users/' . $file->hashName(),
    ]);
});

test('handle: update user details', function () {
    $file = UploadedFile::fake()->image('avatars.jpg');

    App::make(UserUpdateAction::class)->handle([
        'name' => 'User Test',
        'email' => 'updated-test@garage.com',
        'active' => false,
        'image' => $file,
    ], $this->user);

    expect($this->user)->toMatchArray([
        'name' => 'User Test',
        'email' => 'updated-test@garage.com',
        'active' => false,
        'image_path' => 'users/' . $file->hashName(),
    ]);
});

<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserUpdateAction
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(array $attributes, User $user): void
    {
        $data = [];

        $data['user'] = collect($attributes)
            ->only([
                'name',
                'email',
                'active',
            ])
            ->toArray();

        if (array_key_exists('role', $attributes)) {
            $data['role'] = $attributes['role'];
        }

        if (array_key_exists('image', $attributes)) {
            $data['user']['image_path'] = $attributes['image']->store('users', 'public');
        }

        DB::transaction(function () use ($user, $data) {
            // replace old image with new one
            if (array_key_exists('image_path', $data['user'])) {
                if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                    Storage::disk('public')->delete($user->image_path);
                }
            }
            $user->update($data['user']);

            if (array_key_exists('role', $data)) {
                $user->assignRole($data['role']);
            }
        });
    }
}

<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserUpdateAction
{
    public function handle(array $attributes, User|Client $user): User|Client
    {
        $data['user'] = Collection::make($attributes)
            ->only([
                'name',
                'email',
                'active',
                'password',
            ])
            ->filter(fn ($value) => $value !== null)
            ->toArray();

        if (array_key_exists('role', $attributes)) {
            $data['role'] = $attributes['role'];
        }

        if (Arr::has($attributes, 'image') && $attributes['image'] !== null) {
            $data['user']['image_path'] = $attributes['image']->store($user->getTable());
        }

        return DB::transaction(function () use ($user, $data): User|Client {
            // replace old image with new one
            if (
                Arr::has($data, 'user.image_path') &&
                ($user->image_path && Storage::disk('local')->exists($user->image_path))
            ) {
                Storage::disk('local')->delete($user->image_path);
            }

            if (Arr::has($data, 'role')) {
                $user->assignRole($data['role']);
            }

            $user->update($data['user']);
            return $user;
        });
    }
}

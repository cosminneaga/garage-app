<?php

declare(strict_types=1);

namespace App\Actions;

use App\Dto\Coordinates;
use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserStoreAction
{
    public function handle(array $attributes): User
    {
        $data['contact'] = $attributes['contact'];
        $data['address'] = $attributes['address'];
        $data['user'] = collect($attributes)
            ->only([
                'name',
                'email',
                'password',
                'active',
            ])
            ->toArray();
        $data['role'] = $attributes['role'];
        $data['address']['coordinates'] = Coordinates::format($data['address']['coordinates']);

        if (Arr::has($attributes, 'image') && $attributes['image'] !== null) {
            $data['user']['image_path'] = $attributes['image']->store('users', 'public');
        }

        return DB::transaction(function () use ($data) {
            $user = User::create($data['user']);
            $user->assignRole($data['role']);

            $user->addresses()->attach(Address::create($data['address']));
            $user->contacts()->attach(Contact::create($data['contact']));

            return $user;
        });
    }
}

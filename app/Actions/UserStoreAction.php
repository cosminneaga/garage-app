<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserStoreAction
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

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

        if (Arr::has($attributes, 'image') && $attributes['image'] !== null) {
            $data['user']['image_path'] = $attributes['image']->store('users', 'public');
        }

        return DB::transaction(function () use ($data) {
            $user = User::create($data['user']);
            $user->assignRole($data['role']);

            /**
             * 1. must check for current role
             * 2. if role is administrator, $this->user->managers()->attach($created_user);
             * 2.1. if $companies array is present attach to created user
             * 3. if role is manager, $this->user->users()->attach($created_user);
             * 3.1. if $companies array is present attach to created user
             */
            $this->user->team()->attach($user);

            $user->addresses()->attach(Address::updateOrCreateByCoordinates(
                Arr::get($data, 'address.coordinates.latitude'),
                Arr::get($data, 'address.coordinates.longitude'),
                $data['address'],
            ));

            $user->contacts()->attach(Contact::updateOrCreate(
                ['email' => $data['contact']['email']],
                $data['contact'],
            ));

            return $user;
        });
    }
}

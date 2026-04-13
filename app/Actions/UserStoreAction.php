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

    public function handle(array $attributes): void
    {
        $data = [];

        $data['contact'] = $attributes['contact'];
        $data['address'] = collect($attributes['address'])
            ->merge(['country_id' => $attributes['address_country_id']])
            ->toArray();
        $data['user'] = collect($attributes)
            ->only([
                'name',
                'email',
                'password',
                'active',
            ])
            ->toArray();
        $data['role'] = $attributes['role'];

        if (Arr::has($attributes, 'image')) {
            $data['user']['image_path'] = $attributes['image']->store('users', 'public');
        }

        DB::transaction(function () use ($data) {
            $user = User::create($data['user']);
            $user->assignRole($data['role']);

            $this->user->team()->attach($user);

            $user->addresses()->attach(Address::updateOrCreate(
                ['number' => $data['address']['number'], 'street' => $data['address']['street'], 'postcode' => $data['address']['postcode']],
                $data['address']
            ));

            $user->contacts()->attach(Contact::updateOrCreate(
                ['email' => $data['contact']['email']],
                $data['contact']
            ));
        });
    }
}

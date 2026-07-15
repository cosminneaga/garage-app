<?php

declare(strict_types=1);

namespace App\Actions;

use App\Dto\Coordinates;
use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use Exception;
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
        if (!Arr::has($attributes, 'contact') || !Arr::has($attributes, 'address')) {
            throw new Exception('Address & Contact are required when User data is stored');
        }

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

        # In order for MySQL tests to pass we should defined 'coordinates' as 'null'
        $data['address']['coordinates'] = Arr::has($attributes, 'address.coordinates') ? Coordinates::format($data['address']['coordinates']) : null;
        $data['role'] = $this->user->isAdministrator() ? UserRole::MANAGER->value : UserRole::USER->value;

        if (Arr::has($attributes, 'image') && $attributes['image'] !== null) {
            $data['user']['image_path'] = $attributes['image']->store('users', 'public');
        }

        return DB::transaction(function () use ($data) {
            $user = User::create($data['user']);
            $user->assignRole($data['role']);

            $user->addresses()->attach(Address::create($data['address']));
            $user->contacts()->attach(Contact::create($data['contact']));
            
            if ($this->user->isAdministrator()) {
                $this->user->managers()->attach($user);
            } else if ($this->user->isManager()) {
                $this->user->users()->attach($user);
            }

            return $user;
        });
    }
}

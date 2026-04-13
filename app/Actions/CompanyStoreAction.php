<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Exception;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CompanyStoreAction
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(array $attributes)
    {
        if (!$this->user->hasRole(UserRole::USER_ADMIN)) {
            throw new Exception('Only managers should be able to store companies');
        }

        $data = [];

        $data['contact'] = $attributes['contact'];
        $data['address'] = collect($attributes['address'])
            ->merge(['country_id' => $attributes['address_country_id']])
            ->toArray();

        $data['company'] = collect($attributes)
            ->only([
                'name',
                'tax_id',
                'registration_number',
                'tax_value',
                'invoice_prefix',
            ])
            ->toArray();

        if (Arr::has($attributes, 'image')) {
            $data['company']['image_path'] = $attributes['image']->store('companies', 'public');
        }

        DB::transaction(function () use ($data) {
            $company = Company::create($data['company']);
            $company->users()->attach($this->user);

            $company->addresses()->attach(Address::updateOrCreate(
                [
                    'number' => Arr::get($data, 'address.number'),
                    'street' => Arr::get($data, 'address.street'),
                    'postcode' => Arr::get($data, 'address.postcode')
                ],
                $data['address']
            ));

            $company->contacts()->attach(Contact::updateOrCreate(
                ['email' => Arr::get($data, 'contact.email')],
                $data['contact']
            ));
        });
    }
}

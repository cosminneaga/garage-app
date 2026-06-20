<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CompanyStoreAction
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(array $attributes): Company
    {
        $data['contact'] = $attributes['contact'];
        $data['address'] = $attributes['address'];

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

        return DB::transaction(function () use ($data) {
            $company = Company::create($data['company']);
            $company->users()->attach($this->user);

            $company->addresses()->attach(Address::create($data['address']));
            $company->contacts()->attach(Contact::create($data['contact']));

            return $company;
        });
    }
}

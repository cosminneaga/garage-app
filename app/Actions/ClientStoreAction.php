<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Address;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use Exception;
use Illuminate\Support\Facades\DB;
use Pest\Support\Arr;

class ClientStoreAction
{
    public function handle(array $attributes, Company $company): Client
    {
        if (!Arr::has($attributes, 'contact') || !Arr::has($attributes, 'address')) {
            throw new Exception('Address & Contact are required when Supplier data is stored');
        }

        $data['contact'] = $attributes['contact'];
        $data['address'] = $attributes['address'];

        $data['client'] = collect($attributes)
            ->only([
                'name',
                'email',
                'active',
            ])
            ->toArray();

        $exists = $company->findClientByEmail($data['client']['email']);
        if ($exists instanceof Client) {
            return $exists;
        }

        return DB::transaction(function () use ($data, $company) {

            $client = Client::where('email', $data['client']['email'])->first();
            if (!$client) {
                $client = Client::create($data['client']);
            }
            $client->addresses()->attach(Address::create($data['address']));
            $client->contacts()->attach(Contact::create($data['contact']));
            $company->clients()->attach($client);

            return $client;
        });
    }
}

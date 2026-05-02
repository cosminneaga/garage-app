<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelAddressStoreAction
{
    public function handle(array $attributes, Model $model): void
    {
        DB::transaction(function () use ($attributes, $model) {
            $address = Address::updateOrCreate(
                [
                    'number' => $attributes['number'],
                    'street' => $attributes['street'],
                    'postcode' => $attributes['postcode'],
                    'country_id' => $attributes['country_id'],
                ],
                $attributes
            );

            if (! $model->addresses()->find($address->id)) {
                $model->addresses()->attach($address);
            }
        });
    }
}

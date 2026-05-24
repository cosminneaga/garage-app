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
            $address = Address::updateOrCreateByCoordinates(
                $attributes['coordinates']['latitude'],
                $attributes['coordinates']['longitude'],
                $attributes,
            );

            if (! $model->addresses()->find($address->id)) {
                $model->addresses()->attach($address);
            }
        });
    }
}

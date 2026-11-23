<?php

declare(strict_types=1);

namespace App\Actions;

use App\Dto\Coordinates;
use App\Models\Address;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class ModelAddressStoreAction
{
    public function handle(array $attributes, Model $model): Throwable|Address
    {
        $coordinates = Coordinates::format($attributes['coordinates']);
        if ($coordinates) {
            $exists = Address::query()
                ->whereRaw('ST_Y(coordinates) = ?', [$coordinates->latitude], 'and')
                ->whereRaw('ST_X(coordinates) = ?', [$coordinates->longitude], 'and')
                ->exists();
            if ($exists) {
                throw new Exception('Address already exists under same coordinates.');
            }
        }

        return DB::transaction(function () use ($attributes, $model, $coordinates) {
            if (! $model->address) {
                $address = Address::create([
                    ...$attributes,
                    'coordinates' => $coordinates,
                ]);
                $model->address()->associate($address)->save();
            }

            return $address;
        });
    }
}

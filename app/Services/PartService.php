<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Booking;
use App\Models\Company;
use App\Models\Part;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PartService
{
    public function getAllByParentModel(Model $model): Collection
    {
        $model = match($model::class) {
            Booking::class => $model->company,
            Company::class => $model,
        };

        return Part::whereIn('supplier_id', $model->select('id'))->get();
    }
}

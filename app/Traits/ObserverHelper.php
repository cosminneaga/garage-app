<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ObserverHelper
{
    private function columnInsertCheck(Model $model, string $column_name): bool
    {
        return $model->isDirty($column_name) &&
            $model->getOriginal($column_name) === null;
    }

    private function columnChangeCheck(Model $model, string $column_name): bool
    {
        return $model->wasChanged($column_name);
    }
}

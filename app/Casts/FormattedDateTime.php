<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Carbon;

class FormattedDateTime implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y H:i') : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            $key => $value ? Carbon::createFromFormat('d-m-Y H:i', $value) : null,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

class DbHelper
{
    public static function listen(string $type = 'sql'): void
    {
        match ($type) {
            'sql' => DB::listen(fn (QueryExecuted $query) => dump($query->sql)),
            'sql_time' => DB::listen(fn (QueryExecuted $query) => dump('SQL: ' . $query->sql, 'TIME: ' . $query->time)),
            'all' => DB::listen(function (QueryExecuted $query) {
                dump([
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time,
                ]);
            }),
        };
    }
}

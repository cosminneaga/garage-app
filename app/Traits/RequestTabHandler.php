<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\Tabs\CompanyTabs;
use Illuminate\Http\Request;

trait RequestTabHandler
{
    public static function company(Request $request): array
    {
        $tabname = $request->query('tab');

        if (
            ! CompanyTabs::tryFrom($tabname) ||
            $tabname === CompanyTabs::DETAILS->value ||
            $tabname === CompanyTabs::STATISTICS->value
        ) {
            return [];
        }

        return [$tabname];
    }
}

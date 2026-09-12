<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\HasEnumOptions;

enum SupplierType: string
{
    use HasEnumOptions;

    case MANUFACTURER = 'manufacturer';
    case DISTRIBUTOR = 'distributor';
    case LOCAL_VENDOR = 'local_vendor';
    case DEALERSHIP = 'dealership';

    public function label(): string
    {
        return match ($this) {
            self::MANUFACTURER => 'Manufacturer Supplier',
            self::DISTRIBUTOR => 'Distributor Supplier',
            self::LOCAL_VENDOR => 'Local Vendor Supplier',
            self::DEALERSHIP => 'Dealership Supplier',
        };
    }
}

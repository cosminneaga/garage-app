<?php

namespace App\Enums;

enum SupplierType: string
{
    case MANUFACTURER = 'manufacturer';
    case DISTRIBUTOR = 'distributor';
    case LOCAL_VENDOR = 'local_vendor';
    case DEALERSHIP = 'dealership';

    public static function label(): string
    {
        return match ($this) {
            self::MANUFACTURER => 'Manufacturer Supplier',
            self::DISTRIBUTOR => 'Distributor Supplier',
            self::LOCAL_VENDOR => 'Local Vendor Supplier',
            self::DEALERSHIP => 'Dealership Supplied',
        };
    }

    public static function values(): array
    {
        return array_map(fn (SupplierType $status) => $status->value, self::cases());
    }
}

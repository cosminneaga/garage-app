<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Collection;

enum SupplierType: string
{
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

    public static function values(): array
    {
        return array_map(fn (SupplierType $status) => $status->value, self::cases());
    }

    public static function ui(): array
    {
        return new Collection(self::cases())
            ->map(fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ])->toArray();
    }

    public static function getLabel(SupplierType $name): string
    {
        return new Collection(self::cases())
            ->first(fn($item) => $item->value === $name->value)->label();
    }
}

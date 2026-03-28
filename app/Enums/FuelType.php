<?php

namespace App\Enums;

enum FuelType: string
{
    case BIOFUEL = 'biofuel';
    case CNG = 'cng';
    case DIESEL = 'diesel';
    case ELECTRIC = 'electric';
    case HYDROGEN = 'hydrogen';
    case HYBRID = 'hybrid';
    case PETROL = 'petrol';
    case LPG = 'lpg';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::BIOFUEL => 'Biofuel',
            self::CNG => 'Compressed Natural Gas',
            self::DIESEL => 'Diesel',
            self::ELECTRIC => 'Electric',
            self::HYDROGEN => 'Hydrogen',
            self::HYBRID => 'Hybrid (Electric + Fuel)',
            self::PETROL => 'Gasoline (Petrol)',
            self::LPG => 'Liquefied Petroleum Gas',
            self::OTHER => 'Other type of engine ignition material',
        };
    }

    public static function values(): array
    {
        return array_map(fn (FuelType $status) => $status->value, self::cases());
    }
}

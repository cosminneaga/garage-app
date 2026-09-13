<?php

declare(strict_types=1);

namespace App\Enums\Type;

use App\Traits\HasEnumOptions;

enum FuelType: string
{
    use HasEnumOptions;

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
}

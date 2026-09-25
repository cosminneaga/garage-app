<?php

declare(strict_types=1);

namespace App\Enums\Type;

use App\Traits\HasEnumOptions;

enum WorkorderOperationType: string
{
    use HasEnumOptions;

    case ADJUSTMENT = 'adjustment';
    case CALIBRATION = 'calibration';
    case DIAGNOSTICS = 'diagnostics';
    case DISSASEMBLY = 'dissasembly';
    case INSPECTION = 'inspection';
    case INVESTIGATION = 'investigation';
    case REASSEMBLY = 'reassembly';
    case REPAIR = 'repair';
    case REPLACE_PART = 'replace_part';
    case TESTING = 'testing';

    public function label(): string
    {
        return match($this) {
            self::ADJUSTMENT => 'Adjustment',
            self::CALIBRATION => 'Calibration',
            self::DIAGNOSTICS => 'Diagnostics',
            self::DISSASEMBLY => 'Dissasembly',
            self::INSPECTION => 'Inspection',
            self::INVESTIGATION => 'Investigation',
            self::REASSEMBLY => 'Reassembly',
            self::REPAIR => 'Repair',
            self::REPLACE_PART => 'Replace Part',
            self::TESTING => 'Testing',
        };
    }
}

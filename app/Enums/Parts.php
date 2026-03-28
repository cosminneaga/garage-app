<?php

namespace App\Enums;

enum Parts: string
{
    case OIL_CHANGE = 'oil_change';
    case FILTER_REPLACEMENT = 'filter_replacement';
    case FLUID_TOP_UP = 'fluid_top_up';
    case ENGINE_DIAGNOSTICS = 'engine_diagnostics';
    case ENGINE_TUNE_UP = 'engine_tune_up';
    case BRAKE_INSPECTION = 'brake_inspection';
    case BRAKE_PAD_REPLACEMENT = 'brake_pad_replacement';
    case BRAKE_FLUID_CHANGE = 'brake_fluid_change';
    case WHEEL_ALIGNMENT = 'wheel_alignment';
    case SUSPENSION_INSPECTION = 'suspension_inspection';
    case TRANSMISSION_FLUID_CHANGE = 'transmission_fluid_change';
    case CLUTCH_REPLACEMENT = 'clutch_replacement';
    case BATTERY_REPLACEMENT = 'battery_replacement';
    case ALTERNATOR_REPAIR = 'alternator_repair';
    case AC_RECHARGE = 'ac_recharge';

    public function label(): string
    {
        return match ($this) {
            self::OIL_CHANGE => 'Oil Change',
            self::FILTER_REPLACEMENT => 'Filter Replacement',
            self::FLUID_TOP_UP => 'Fluid Top-Up',
            self::ENGINE_DIAGNOSTICS => 'Engine Diagnostics',
            self::ENGINE_TUNE_UP => 'Engine Tune-Up',
            self::BRAKE_INSPECTION => 'Brake Inspection',
            self::BRAKE_PAD_REPLACEMENT => 'Brake Pad Replacement',
            self::BRAKE_FLUID_CHANGE => 'Brake Fluid Change',
            self::WHEEL_ALIGNMENT => 'Wheel Alignment',
            self::SUSPENSION_INSPECTION => 'Suspension Inspection',
            self::TRANSMISSION_FLUID_CHANGE => 'Transmission Fluid Change',
            self::CLUTCH_REPLACEMENT => 'Clutch Replacement',
            self::BATTERY_REPLACEMENT => 'Battery Replacement',
            self::ALTERNATOR_REPAIR => 'Alternator Repair',
            self::AC_RECHARGE => 'A/C Recharge',
        };
    }

    public static function values(): array
    {
        return array_map(fn (Parts $status) => $status->value, self::cases());
    }
}

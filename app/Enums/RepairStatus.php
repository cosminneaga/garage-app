<?php

declare(strict_types=1);

namespace App\Enums;

enum RepairStatus: string
{
    case RECEPTION = 'reception';
    case INITIAL_INSPECTION = 'initial_inspection';
    case DIAGNOSIS = 'diagnosis';
    case ESTIMATE = 'estimate';
    case APPROVAL = 'waiting_approval';
    case REPAIR = 'repair';
    case TESTING = 'testing';
    case FINAL_INSPECTION = 'final_inspection';
    case DELIVERY = 'delivery';

    public function label(): string
    {
        return match ($this) {
            self::RECEPTION => 'Reception / Intake',
            self::INITIAL_INSPECTION => 'Initial Inspection',
            self::DIAGNOSIS => 'Diagnosis',
            self::ESTIMATE => 'Estimate',
            self::APPROVAL => 'Waiting Approval',
            self::REPAIR => 'Repair/Replacement',
            self::TESTING => 'Quality Check/Testing',
            self::FINAL_INSPECTION => 'Final Inspection',
            self::DELIVERY => 'Delivered',
        };
    }

    public static function values(): array
    {
        return array_map(fn (RepairStatus $status) => $status->value, self::cases());
    }
}

<?php

declare(strict_types=1);

namespace App\Enums;

enum FileType: string
{
    case AFTER_REPAIR = 'after_repair';
    case BEFORE_REPAIR = 'before_repair';
    case CLIENT_REFERENCE = 'client_reference';
    case DAMAGE_EVIDENCE = 'damage_evidence';
    case DIAGNOSTIC = 'diagnostic';
    case DOCUMENT = 'document';
    case DURING_REPAIR = 'during_repair';
    case INSPECTION = 'inspection';
    case INVOICE = 'invoice';
    case NEW_PART = 'new_part';
    case OLD_PART = 'old_part';
    case OTHER = 'other';
    case PART = 'part';
    case SHOWCASE = 'showcase';

    public function label(): string
    {
        return match ($this) {
            self::AFTER_REPAIR => 'After Repair',
            self::BEFORE_REPAIR => 'Before Repair',
            self::CLIENT_REFERENCE => 'Client reference',
            self::DAMAGE_EVIDENCE => 'Damage evidence',
            self::DIAGNOSTIC => 'Diagnostic',
            self::DOCUMENT => 'Document',
            self::DURING_REPAIR => 'File showcasing repair progress',
            self::INSPECTION => 'Inspection stage',
            self::NEW_PART => 'New part installed',
            self::OLD_PART => 'Old part removed',
            self::PART => 'Vehicle Part',
            self::SHOWCASE => 'Showcase File',
        };
    }

    public static function values(): array
    {
        return array_map(fn (FileType $status) => $status->value, self::cases());
    }
}

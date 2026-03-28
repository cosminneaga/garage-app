<?php

namespace App\Enums;

enum FileStatus: string
{
    case BEFORE = 'before';
    case AFTER = 'after';

    public function label(): string
    {
        return match ($this) {
            self::BEFORE => 'Before Repair',
            self::AFTER => 'After Repair',
        };
    }

    public static function values(): array
    {
        return array_map(fn (FileStatus $status) => $status->value, self::cases());
    }
}

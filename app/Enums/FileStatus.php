<?php

declare(strict_types=1);

namespace App\Enums;

enum FileStatus: string
{
    case BEFORE = 'before';
    case AFTER = 'after';
    case SHOWCASE = 'showcase';

    public function label(): string
    {
        return match ($this) {
            self::BEFORE => 'Before Repair',
            self::AFTER => 'After Repair',
            self::SHOWCASE => 'Showcase File',
        };
    }

    public static function values(): array
    {
        return array_map(fn (FileStatus $status) => $status->value, self::cases());
    }
}

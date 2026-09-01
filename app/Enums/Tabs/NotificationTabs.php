<?php

declare(strict_types=1);

namespace App\Enums\Tabs;

use Illuminate\Support\Collection;

enum NotificationTabs: string
{
    case UNREAD = 'unread';
    case READ = 'read';
    case ALL = 'all';

    public function label(): string
    {
        return match($this) {
            self::UNREAD => 'Unread',
            self::READ => 'Read',
            self::ALL => 'All',
        };
    }

    public static function ui(): array
    {
        return new Collection(self::cases())
            ->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
                'slug' => $case->value,
            ])->toArray();
    }
}

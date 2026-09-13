<?php

declare(strict_types=1);

namespace App\Enums\Tabs;

use App\Traits\HasEnumOptions;

enum NotificationTabs: string
{
    use HasEnumOptions;

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
}

<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case SUPER = 'super';
    case USER_ADMIN = 'user_admin';
    case USER_EDITOR = 'user_editor';
    case USER_VIEWER = 'user_viewer';

    public function label(): string
    {
        return match ($this) {
            self::SUPER => 'Application Administrator',
            self::USER_ADMIN => 'User Administrator over it\'s own companies, users, vehicles, clients, invoices',
            self::USER_EDITOR => 'User Editor over it\'s own companies, users, vehicles, clients, invoices',
            self::USER_VIEWER => 'User Viewer over it\'s own companies, users, vehicles, clients, invoices'
        };
    }

    public static function values(): array
    {
        return array_map(fn (UserRole $status) => $status->value, self::cases());
    }
}

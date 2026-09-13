<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\HasEnumOptions;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

enum UserRole: string
{
    use HasEnumOptions;

    case SUPER = 'super';
    case ADMINISTRATOR = 'administrator';
    case MANAGER = 'manager';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            self::SUPER => 'Application Administrator',
            self::ADMINISTRATOR => 'Companies Administrator',
            self::MANAGER => 'Specific companies administrator & manager',
            self::USER => 'Tipical user',
        };
    }

    public static function findByRole(Role $role): ?UserRole
    {
        return new Collection(self::cases())
            ->first(fn ($item) => $item->value === $role->name);
    }
}

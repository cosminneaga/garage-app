<?php

declare(strict_types=1);

namespace App\Enums;

use stdClass;
use ErrorException;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

// !!! TESTING - unit/enum/EnumUserRoleTest.php
enum UserRole: string
{
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

    public static function relation(UserRole $role): stdClass
    {
        return match($role) {
            self::ADMINISTRATOR => (object) [
                'table_name' => 'team_administrator_managers',
                'columns' => [
                    (object) ['type' => 'pk', 'value' => 'administrator_id'],
                    (object) ['type' => 'fk', 'value' => 'manager_id'],
                ],
            ],
            self::MANAGER => (object) [
                'table_name' => 'team_manager_users',
                'columns' => [
                    (object) ['type' => 'pk', 'value' => 'manager_id'],
                    (object) ['type' => 'fk', 'value' => 'user_id'],
                ],
            ],
            self::USER => (object) [
                'table_name' => 'team_manager_users',
                'columns' => [
                    (object) ['type' => 'pk', 'value' => 'user_id'],
                    (object) ['type' => 'fk', 'value' => 'manager_id'],
                ],
            ],
        };
    }

    public static function mapRelation(UserRole $start, UserRole $end): Collection
    {
        if ($start === $end) {
            throw new ErrorException('Roles should not be same');
        }

        $roles = new Collection(self::cases())
            ->reject(fn ($role) => $role === UserRole::SUPER)
            ->map(fn (UserRole $role) => self::relation($role))
            ->values();
        $startIndex = $roles->search(self::relation($start));
        $endIndex = $roles->search(self::relation($end));

        if ($startIndex > $endIndex) {
            $roles = $roles
                ->reverse()
                ->values();
            $startIndex = $roles->search(self::relation($start));
            $endIndex = $roles->search(self::relation($end));
            $roles = $roles->slice($startIndex, $endIndex - $startIndex + 1)->values();

            $roles->first()->columns = array_reverse($roles[$roles->keys()->first()]->columns);
            $roles->last()->columns = array_reverse($roles[$roles->keys()->last()]->columns);

            return count($roles) > 2 ? $roles : $roles->reverse()->values();
        }

        return $roles->slice($startIndex, $endIndex - $startIndex + 1)->values();
    }

    public static function values(): array
    {
        return new Collection(self::cases())
            ->map(fn ($role) => $role->value)
            ->toArray();
    }

    public static function ui(): array
    {
        return new Collection(self::cases())
            ->reject(fn ($role) => $role->value === 'super')
            ->map(fn ($role) => [
                'value' => $role->value,
                'label' => $role->label(),
            ])->values()->toArray();
    }

    public static function findByRole(Role $role): ?UserRole
    {
        return new Collection(self::cases())
            ->first(fn ($item) => $item->value === $role->name);
    }
}

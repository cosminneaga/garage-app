<?php

declare(strict_types=1);

namespace App\Enums;

use ErrorException;
use Illuminate\Support\Collection;

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

    public static function relation(UserRole $role): array
    {
        return match($role) {
            self::ADMINISTRATOR => [
                'table_name' => 'team_administrator_managers',
                'columns' => ['administrator_id', 'manager_id'],
            ],
            self::MANAGER => [
                'table_name' => 'team_manager_users',
                'columns' => ['manager_id', 'user_id'],
            ],
            self::USER => [
                'table_name' => 'team_manager_users',
                'columns' => ['user_id', 'manager_id'],
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
            ->map(fn ($role) => self::relation($role))
            ->values();
        $startIndex = $roles->search(self::relation($start));
        $endIndex = $roles->search(self::relation($end));

        if ($startIndex > $endIndex) {
            $roles = $roles->reverse()->values();
            $startIndex = $roles->search(self::relation($start));
            $endIndex = $roles->search(self::relation($end));
        }

        $roles = $roles->slice($startIndex, $endIndex - $startIndex + 1)->values();

        return $roles;
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
                'name' => $role->value,
                'label' => $role->label(),
            ])->toArray();
    }

    public static function findByName(string $name): ?UserRole
    {
        return new Collection(self::cases())
            ->first(fn ($item) => $item->value === $name);
    }
}

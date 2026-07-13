<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

enum Environment: string
{
    case PRODUCTION = 'production';
    case LOCAL = 'local';
    case TEST = 'test';

    public static function getBase(Environment $environment)
    {
        return match ($environment) {
            self::PRODUCTION => [
                UserRole::ADMINISTRATOR->value => [
                    ...UserPermission::list(
                        excludeReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ]
                    ),
                    ...UserPermission::list(
                        onlyReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ],
                        onlyActions: ['show']
                    ),
                ],
                UserRole::MANAGER->value => [
                    ...UserPermission::list(
                        excludeReferences: [
                            'country',
                            'company',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ]
                    ),
                    ...UserPermission::list(
                        onlyReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ],
                        onlyActions: ['show']
                    ),
                    ...UserPermission::list(
                        onlyReferences: ['company'],
                        onlyActions: ['show', 'update']
                    ),
                ],
                UserRole::USER->value => [
                    ...UserPermission::list(
                        onlyReferences: [
                            'address',
                            'booking',
                            'contact',
                            'company',
                            'country',
                            'client',
                            'supplier',
                            'permission',
                            'repair',
                            'repair_file',
                            'repair_invoice',
                            'repair_invoice_item',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                            'user',
                        ],
                        onlyActions: ['show']
                    ),
                ],
            ],
            self::LOCAL => [
                UserRole::ADMINISTRATOR->value => [
                    ...UserPermission::list(
                        excludeReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ]
                    ),
                    ...UserPermission::list(
                        onlyReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ],
                        onlyActions: ['show']
                    ),
                ],
                UserRole::MANAGER->value => [
                    ...UserPermission::list(
                        excludeReferences: [
                            'country',
                            'company',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ]
                    ),
                    ...UserPermission::list(
                        onlyReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ],
                        onlyActions: ['show']
                    ),
                    ...UserPermission::list(
                        onlyReferences: ['company'],
                        onlyActions: ['show', 'update']
                    ),
                ],
                UserRole::USER->value => [
                    ...UserPermission::list(
                        onlyReferences: [
                            'address',
                            'booking',
                            'contact',
                            'company',
                            'country',
                            'client',
                            'supplier',
                            'permission',
                            'repair',
                            'repair_file',
                            'repair_invoice',
                            'repair_invoice_item',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                            'user',
                        ],
                        onlyActions: ['show']
                    ),
                ],
            ],
            self::TEST => [
                UserRole::ADMINISTRATOR->value => [
                    ...UserPermission::list(
                        excludeReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ]
                    ),
                    ...UserPermission::list(
                        onlyReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ],
                        onlyActions: ['show']
                    ),
                ],
                UserRole::MANAGER->value => [
                    ...UserPermission::list(
                        excludeReferences: [
                            'country',
                            'company',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ]
                    ),
                    ...UserPermission::list(
                        onlyReferences: [
                            'country',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                        ],
                        onlyActions: ['show']
                    ),
                    ...UserPermission::list(
                        onlyReferences: ['company'],
                        onlyActions: ['show', 'update']
                    ),
                ],
                UserRole::USER->value => [
                    ...UserPermission::list(
                        onlyReferences: [
                            'address',
                            'booking',
                            'contact',
                            'company',
                            'country',
                            'client',
                            'supplier',
                            'permission',
                            'repair',
                            'repair_file',
                            'repair_invoice',
                            'repair_invoice_item',
                            'vehicle_data',
                            'vehicle_make',
                            'vehicle_model',
                            'vehicle_year',
                            'user',
                        ],
                        onlyActions: ['show']
                    ),
                ],
            ],
        };
    }

    public static function insertRoles(): void
    {
        Role::findOrCreate(UserRole::SUPER->value);
        Role::findOrCreate(UserRole::ADMINISTRATOR->value);
        Role::findOrCreate(UserRole::MANAGER->value);
        Role::findOrCreate(UserRole::USER->value);
    }

    public static function insertPermissions(): void
    {
        Collection::make(UserPermission::list())
            ->each(fn (string $permission) => Permission::findOrCreate($permission));
    }

    public static function insertPermissionsByEnvironment(Environment $environment, UserRole $role)
    {
        $baseByType = Collection::make(self::getBase($environment))->get($role->value);

        return Collection::make($baseByType)
            ->map(function ($name) {
                $permission = DB::table('permissions')
                    ->where('name', $name)
                    ->lockForUpdate()
                    ->first();

                if ($permission) {
                    return $permission->id;
                }

                return DB::table('permissions')->insertGetId([
                    'name' => $name,
                    'guard_name' => 'web',
                ]);
            })
            ->toArray();
    }

    public static function assignPermissionsToRole(UserRole $role, array $permissionIds)
    {
        $roleId = Role::where('name', $role->value)->first()->id;

        return Collection::make($permissionIds)
            ->map(function ($permissionId) use ($roleId) {
                $assign = DB::table('role_has_permissions')
                    ->where('permission_id', $permissionId)
                    ->where('role_id', $roleId)
                    ->lockForUpdate()
                    ->first();

                if ($assign) {
                    return $assign;
                }

                return DB::table('role_has_permissions')
                    ->insert([
                        'role_id' => $roleId,
                        'permission_id' => $permissionId,
                    ]);
            });
    }
}

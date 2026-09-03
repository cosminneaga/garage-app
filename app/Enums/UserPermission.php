<?php

declare(strict_types=1);

namespace App\Enums;

use Exception;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

// !!! TESTING - tests/SQLite/EnumUserPermissionTest.php
enum UserPermission: string
{
    // Table <-> Permission references
    case ADDRESS = 'address';
    case CLIENT = 'client';
    case COMPANY = 'company';
    case CONTACT = 'contact';
    case COUNTRY = 'country';
    case PRODUCT = 'product';
    case SUPPLIER = 'supplier';
    case PART = 'part';
    case VEHICLE = 'vehicle';

    case FILE = 'file';

    case BOOKING = 'booking';
    case WORKORDER = 'workorder';
    case WORKORDER_OPERATION = 'workorder_operation';
    case WORKORDER_OPERATION_LABOUR_TIME = 'workorder_operation_labour_time';
    case INVOICE = 'invoice';
    case INVOICE_ITEM = 'invoice_item';

    case USER = 'user';
    case MANAGER = 'manager';

    case VEHICLE_DATA = 'vehicle_data';
    case VEHICLE_MAKE = 'vehicle_make';
    case VEHICLE_MODEL = 'vehicle_model';
    case VEHICLE_YEAR = 'vehicle_year';

    case PERMISSION = 'permission';

    public function label(): string
    {
        return match ($this) {
            self::ADDRESS => 'Address',
            self::CLIENT => 'Client',
            self::COMPANY => 'Company',
            self::CONTACT => 'Contact',
            self::COUNTRY => 'Company',
            self::PRODUCT => 'Product',
            self::SUPPLIER => 'Supplier',
            self::PART => 'Vehicle Part',
            self::VEHICLE => 'Vehicle',

            self::FILE => 'File',

            self::BOOKING => 'Booking',
            self::WORKORDER => 'Workorder',
            self::WORKORDER_OPERATION => 'Workorder Operation',
            self::WORKORDER_OPERATION_LABOUR_TIME => 'Workorder Operation Labour Time',
            self::INVOICE => 'Invoice',
            self::INVOICE_ITEM => 'Invoice Item',

            self::USER => 'User',
            self::MANAGER => 'Manager',

            self::VEHICLE_DATA => 'Vehicle Data',
            self::VEHICLE_MAKE => 'Vehicle Make',
            self::VEHICLE_MODEL => 'Vehicle Model',
            self::VEHICLE_YEAR => 'Vehicle Year',

            self::PERMISSION => 'Permission',
        };
    }

    public static function actions(): array
    {
        return [
            'show' => 'show',
            'store' => 'store',
            'update' => 'update',
            'delete' => 'delete',
            'restore' => 'restore',
        ];
    }

    /**
     * Retrieve an array of available references
     *
     * @return array ['vehicle_data', 'vehicle_make', 'vehicle_model', 'vehicle_year']
     */
    public static function references(): array
    {
        return array_map(fn (UserPermission $userPermission) => $userPermission->value, self::cases());
    }

    /**
     * Retrieve the name of reference with action combined as standardized form
     *
     * @param  UserPermission  $reference  UserPermission reference this must exists in enum's cases
     * @param  string  $action_name  Action must also exists in self::actions()
     * @return string 'user-show'
     */
    public static function name(UserPermission $reference, string $action_name): string
    {
        if (! array_key_exists($action_name, self::actions())) {
            throw new Exception("Action: $action_name does not exists in: " . implode(',', self::actions()));
        }

        return $reference->value . '-' . self::actions()[$action_name];
    }

    /**
     * Retrieve a list of a single dimension array of references(table names) and their actions
     *
     * This method would return an array of a single dimension
     * having the references(tables) combined with their action names.
     *
     * Useful when we want to create permission names, or use these to list them
     * somewhere in UI or in a controller/service functionality.
     *
     * Example: 'user-show', 'vehicle_data-delete'
     *
     * @param  array  $excludeReferences  Optional excluding references
     * @param  array  $excludeActions  Optional excluding actions
     */
    public static function list(
        array $excludeReferences = [],
        array $excludeActions = [],
        array $onlyReferences = [],
        array $onlyActions = [],
    ): array {
        $result = [];

        foreach (self::references() as $reference) {
            if (collect($excludeReferences)->contains($reference)) {
                continue;
            }

            if ($onlyReferences !== [] && ! collect($onlyReferences)->contains($reference)) {
                continue;
            }

            foreach (self::actions() as $action) {
                if (collect($excludeActions)->contains($action)) {
                    continue;
                }

                if ($onlyActions !== [] && ! collect($onlyActions)->contains($action)) {
                    continue;
                }
                $result[] = "$reference-$action";
            }
        }

        return $result;
    }

    public static function tableStructure(Collection $existing_permissions): Collection
    {
        $result = Collection::make();
        $existingPermissionNames = $existing_permissions->map(fn ($in) => $in->name);

        foreach (self::references() as $reference) {
            foreach (self::actions() as $action_name) {
                if ($existingPermissionNames->containsStrict($reference . '-' . $action_name)) {
                    $result->push($existing_permissions->firstWhere('name', $reference . '-' . $action_name));
                    continue;
                }

                $result->push(new Permission([
                    'id' => null,
                    'name' => $reference . '-' . $action_name,
                    'guard_name' => 'web',
                    'created_at' => null,
                    'updated_at' => null,
                    'available' => true,
                ]));
            }
        }

        return $result->sortByDesc(['pivot.model_id', 'available'])->values();
    }
}

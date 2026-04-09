<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Collect;
use Exception;

enum UserPermission: string
{
    use Collect;

        // Table <-> Permission references
    case ADDRESS = 'address';
    case BOOKING = 'booking';
    case CLIENT = 'client';
    case COMPANY = 'company';
    case COUNTRY = 'country';
    case PRODUCT = 'product';
    case SUPPLIER = 'supplier';

    case REPAIR = 'repair';
    case REPAIR_FILE = 'repair_file';
    case REPAIR_INVOICE = 'repair_invoice';
    case REPAIR_INVOICE_ITEM = 'repair_invoice_item';

    case USER = 'user';

    case VEHICLE_DATA = 'vehicle_data';
    case VEHICLE_MAKE = 'vehicle_make';
    case VEHICLE_MODEL = 'vehicle_model';
    case VEHICLE_YEAR = 'vehicle_year';

    public function label(): string
    {
        return match ($this) {
            self::ADDRESS => 'Address',
            self::BOOKING => 'Booking',
            self::CLIENT => 'Client',
            self::COMPANY => 'Company',
            self::COUNTRY => 'Company',
            self::PRODUCT => 'Product',
            self::SUPPLIER => 'Supplier',

            self::REPAIR => 'Repair',
            self::REPAIR_FILE => 'Repair File',
            self::REPAIR_INVOICE => 'Repair Invoice',
            self::REPAIR_INVOICE_ITEM => 'Repair Invoice Item',

            self::USER => 'User',

            self::VEHICLE_DATA => 'Vehicle Data',
            self::VEHICLE_MAKE => 'Vehicle Make',
            self::VEHICLE_MODEL => 'Vehicle Model',
            self::VEHICLE_YEAR => 'Vehicle Year',
        };
    }

    public static function actions(): array
    {
        return [
            'show_all' => 'show_all',
            'show' => 'show',
            'store' => 'store',
            'update' => 'update',
            'delete' => 'delete',
            'force_delete' => 'force_delete',
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
        return array_map(fn(UserPermission $userPermission) => $userPermission->value, self::cases());
    }

    /**
     * Retrieve the name of reference with action combined as standardized form
     *
     * @param UserPermission $reference UserPermission reference this must exists in enum's cases
     * @param string $action_name Action must also exists in self::actions()
     *
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
     * @param array $excludeReferences Optional excluding references
     * @param array $excludeActions Optional excluding actions
     */
    public static function list(
        array $excludeReferences = [],
        array $excludeActions = [],
        array $onlyReferences = [],
        array $onlyActions = []
    ): array {
        $result = [];

        foreach (self::references() as $reference) {
            if (collect($excludeReferences)->contains($reference)) {
                continue;
            }

            if (!empty($onlyReferences) && !collect($onlyReferences)->contains($reference)) {
                continue;
            }

            foreach (self::actions() as $action) {
                if (collect($excludeActions)->contains($action)) {
                    continue;
                }

                if (!empty($onlyActions) && !collect($onlyActions)->contains($action)) {
                    continue;
                }
                $result[] = "$reference-$action";
            }
        }

        return $result;
    }
}

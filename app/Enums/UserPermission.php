<?php

declare(strict_types=1);

namespace App\Enums;

use Exception;

enum UserPermission: string
{
    // Table <-> Permission references
    case ADDRESS = 'address';
    case BOOKINGS = 'booking';
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

    public static function references(): array
    {
        return array_map(fn (UserPermission $userPermission) => $userPermission->value, self::cases());
    }

    public static function list(bool $singleDimension = true, array $excludeActions = []): array
    {
        // TODO: create $includeActions which cancels $excludeActions
        // TODO: if $singleDimension = false the $excludeActions won't apply, please fix

        if ($excludeActions !== [] && ! collect($excludeActions)->values()->every(fn ($value) => in_array($value, self::actions()))) {
            throw new Exception('Actions: '.implode(',', $excludeActions).' does not exists in: '.implode(',', self::actions()));
        }

        if ($singleDimension) {
            $result = [];

            foreach (self::references() as $reference) {
                foreach (self::actions() as $action) {
                    if (collect($excludeActions)->contains($action)) {
                        continue;
                    }
                    $result[] = "$reference-$action";
                }
            }

            return $result;
        }

        return array_map(fn ($reference) => array_map(fn (string $action) => "$reference.$action", self::actions()), self::references());
    }

    public static function name(UserPermission $reference, string $action_name): string
    {
        if (! array_key_exists($action_name, self::actions())) {
            throw new Exception("Action: $action_name does not exists in: ".implode(',', self::actions()));
        }

        return $reference->value.'-'.self::actions()[$action_name];
    }
}

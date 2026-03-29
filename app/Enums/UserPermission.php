<?php

declare(strict_types=1);

namespace App\Enums;

enum UserPermission: string
{
    // Address
    case ADDRESS_SHOW = 'address_show';
    case ADDRESS_STORE = 'address_store';
    case ADDRESS_UPDATE = 'address_update';
    case ADDRESS_DELETE = 'address_delete';
    case ADDRESS_RESTORE = 'address_restore';

    // Client
    case CLIENT_SHOW = 'client_show';
    case CLIENT_STORE = 'client_store';
    case CLIENT_UPDATE = 'client_update';
    case CLIENT_DELETE = 'client_delete';
    case CLIENT_RESTORE = 'client_restore';

    // Company
    case COMPANY_SHOW = 'company_show';
    case COMPANY_STORE = 'company_store';
    case COMPANY_UPDATE = 'company_update';
    case COMPANY_DELETE = 'company_delete';
    case COMPANY_RESTORE = 'company_restore';

    // Country
    case COUNTRY_SHOW = 'country_show';
    case COUNTRY_STORE = 'country_store';
    case COUNTRY_UPDATE = 'country_update';
    case COUNTRY_DELETE = 'country_delete';
    case COUNTRY_RESTORE = 'country_restore';

    // Product
    case PRODUCT_SHOW = 'product_show';
    case PRODUCT_STORE = 'product_store';
    case PRODUCT_UPDATE = 'product_update';
    case PRODUCT_DELETE = 'product_delete';
    case PRODUCT_RESTORE = 'product_restore';

    // Repair
    case REPAIR_SHOW = 'repair_show';
    case REPAIR_STORE = 'repair_store';
    case REPAIR_UPDATE = 'repair_update';
    case REPAIR_DELETE = 'repair_delete';
    case REPAIR_RESTORE = 'repair_restore';

    // Repair File
    case REPAIR_FILE_SHOW = 'repair-file_show';
    case REPAIR_FILE_STORE = 'repair-file_store';
    case REPAIR_FILE_UPDATE = 'repair-file_update';
    case REPAIR_FILE_DELETE = 'repair-file_delete';
    case REPAIR_FILE_RESTORE = 'repair-file_restore';

    // Repair Invoice
    case REPAIR_INVOICE_SHOW = 'repair-invoice_show';
    case REPAIR_INVOICE_STORE = 'repair-invoice_store';
    case REPAIR_INVOICE_UPDATE = 'repair-invoice_update';
    case REPAIR_INVOICE_DELETE = 'repair-invoice_delete';
    case REPAIR_INVOICE_RESTORE = 'repair-invoice_restore';

    // Repair Invoice Item
    case REPAIR_INVOICE_ITEM_SHOW = 'repair-invoice-item_show';
    case REPAIR_INVOICE_ITEM_STORE = 'repair-invoice-item_store';
    case REPAIR_INVOICE_ITEM_UPDATE = 'repair-invoice-item_update';
    case REPAIR_INVOICE_ITEM_DELETE = 'repair-invoice-item_delete';
    case REPAIR_INVOICE_ITEM_RESTORE = 'repair-invoice-item_restore';

    // User
    case USER_SHOW = 'user_show';
    case USER_STORE = 'user_store';
    case USER_UPDATE = 'user_update';
    case USER_DELETE = 'user_delete';
    case USER_RESTORE = 'user_restore';

    // Vehicle Data
    case VEHICLE_DATA_SHOW = 'vehicle-data_show';
    case VEHICLE_DATA_STORE = 'vehicle-data_store';
    case VEHICLE_DATA_UPDATE = 'vehicle-data_update';
    case VEHICLE_DATA_DELETE = 'vehicle-data_delete';
    case VEHICLE_DATA_RESTORE = 'vehicle-data_restore';

    // Vehicle Make
    case VEHICLE_MAKE_SHOW = 'vehicle-make_show';
    case VEHICLE_MAKE_STORE = 'vehicle-make_store';
    case VEHICLE_MAKE_UPDATE = 'vehicle-make_update';
    case VEHICLE_MAKE_DELETE = 'vehicle-make_delete';
    case VEHICLE_MAKE_RESTORE = 'vehicle-make_restore';

    // Vehicle Model
    case VEHICLE_MODEL_SHOW = 'vehicle-model_show';
    case VEHICLE_MODEL_STORE = 'vehicle-model_store';
    case VEHICLE_MODEL_UPDATE = 'vehicle-model_update';
    case VEHICLE_MODEL_DELETE = 'vehicle-model_delete';
    case VEHICLE_MODEL_RESTORE = 'vehicle-model_restore';

    // Vehicle Year
    case VEHICLE_YEAR_SHOW = 'vehicle-year_show';
    case VEHICLE_YEAR_STORE = 'vehicle-year_store';
    case VEHICLE_YEAR_UPDATE = 'vehicle-year_update';
    case VEHICLE_YEAR_DELETE = 'vehicle-year_delete';
    case VEHICLE_YEAR_RESTORE = 'vehicle-year_restore';

    public function label(): string
    {
        return match ($this) {
            // Address
            self::ADDRESS_SHOW => 'View Address',
            self::ADDRESS_STORE => 'Create Address',
            self::ADDRESS_UPDATE => 'Update Address',
            self::ADDRESS_DELETE => 'Delete Address',
            self::ADDRESS_RESTORE => 'Restore Address',

            // Client
            self::CLIENT_SHOW => 'View Client',
            self::CLIENT_STORE => 'Create Client',
            self::CLIENT_UPDATE => 'Update Client',
            self::CLIENT_DELETE => 'Delete Client',
            self::CLIENT_RESTORE => 'Restore Client',

            // Company
            self::COMPANY_SHOW => 'View Company',
            self::COMPANY_STORE => 'Create Company',
            self::COMPANY_UPDATE => 'Update Company',
            self::COMPANY_DELETE => 'Delete Company',
            self::COMPANY_RESTORE => 'Restore Company',

            // Country
            self::COUNTRY_SHOW => 'View Country',
            self::COUNTRY_STORE => 'Create Country',
            self::COUNTRY_UPDATE => 'Update Country',
            self::COUNTRY_DELETE => 'Delete Country',
            self::COUNTRY_RESTORE => 'Restore Country',

            // Product
            self::PRODUCT_SHOW => 'View Product',
            self::PRODUCT_STORE => 'Create Product',
            self::PRODUCT_UPDATE => 'Update Product',
            self::PRODUCT_DELETE => 'Delete Product',
            self::PRODUCT_RESTORE => 'Restore Product',

            // Repair
            self::REPAIR_SHOW => 'View Repair',
            self::REPAIR_STORE => 'Create Repair',
            self::REPAIR_UPDATE => 'Update Repair',
            self::REPAIR_DELETE => 'Delete Repair',
            self::REPAIR_RESTORE => 'Restore Repair',

            // Repair File
            self::REPAIR_FILE_SHOW => 'View Repair File',
            self::REPAIR_FILE_STORE => 'Create Repair File',
            self::REPAIR_FILE_UPDATE => 'Update Repair File',
            self::REPAIR_FILE_DELETE => 'Delete Repair File',
            self::REPAIR_FILE_RESTORE => 'Restore Repair File',

            // Repair Invoice
            self::REPAIR_INVOICE_SHOW => 'View Repair Invoice',
            self::REPAIR_INVOICE_STORE => 'Create Repair Invoice',
            self::REPAIR_INVOICE_UPDATE => 'Update Repair Invoice',
            self::REPAIR_INVOICE_DELETE => 'Delete Repair Invoice',
            self::REPAIR_INVOICE_RESTORE => 'Restore Repair Invoice',

            // Repair Invoice Item
            self::REPAIR_INVOICE_ITEM_SHOW => 'View Repair Invoice Item',
            self::REPAIR_INVOICE_ITEM_STORE => 'Create Repair Invoice Item',
            self::REPAIR_INVOICE_ITEM_UPDATE => 'Update Repair Invoice Item',
            self::REPAIR_INVOICE_ITEM_DELETE => 'Delete Repair Invoice Item',
            self::REPAIR_INVOICE_ITEM_RESTORE => 'Restore Repair Invoice Item',

            // User
            self::USER_SHOW => 'View User',
            self::USER_STORE => 'Create User',
            self::USER_UPDATE => 'Update User',
            self::USER_DELETE => 'Delete User',
            self::USER_RESTORE => 'Restore User',

            // Vehicle Data
            self::VEHICLE_DATA_SHOW => 'View Vehicle Data',
            self::VEHICLE_DATA_STORE => 'Create Vehicle Data',
            self::VEHICLE_DATA_UPDATE => 'Update Vehicle Data',
            self::VEHICLE_DATA_DELETE => 'Delete Vehicle Data',
            self::VEHICLE_DATA_RESTORE => 'Restore Vehicle Data',

            // Vehicle Make
            self::VEHICLE_MAKE_SHOW => 'View Vehicle Make',
            self::VEHICLE_MAKE_STORE => 'Create Vehicle Make',
            self::VEHICLE_MAKE_UPDATE => 'Update Vehicle Make',
            self::VEHICLE_MAKE_DELETE => 'Delete Vehicle Make',
            self::VEHICLE_MAKE_RESTORE => 'Restore Vehicle Make',

            // Vehicle Model
            self::VEHICLE_MODEL_SHOW => 'View Vehicle Model',
            self::VEHICLE_MODEL_STORE => 'Create Vehicle Model',
            self::VEHICLE_MODEL_UPDATE => 'Update Vehicle Model',
            self::VEHICLE_MODEL_DELETE => 'Delete Vehicle Model',
            self::VEHICLE_MODEL_RESTORE => 'Restore Vehicle Model',

            // Vehicle Year
            self::VEHICLE_YEAR_SHOW => 'View Vehicle Year',
            self::VEHICLE_YEAR_STORE => 'Create Vehicle Year',
            self::VEHICLE_YEAR_UPDATE => 'Update Vehicle Year',
            self::VEHICLE_YEAR_DELETE => 'Delete Vehicle Year',
            self::VEHICLE_YEAR_RESTORE => 'Restore Vehicle Year',
        };
    }

    public static function values(): array
    {
        return array_map(fn (UserPermission $userPermission) => $userPermission->value, self::cases());
    }
}

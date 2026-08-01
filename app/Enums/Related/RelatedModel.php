<?php

declare(strict_types=1);

namespace App\Enums\Related;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreRepairRequest;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\UpdateInvoiceItemRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Address;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use App\Models\File;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Repair;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\AddressPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Model;

enum RelatedModel: string
{
    case ADDRESS = 'address';
    case BOOKING = 'booking';
    case COMPANY = 'company';
    case CONTACT = 'contact';
    case CLIENT = 'client';
    case FILE = 'file';
    case INVOICE = 'invoice';
    case INVOICE_ITEM = 'invoice_item';
    case PRODUCT = 'product';
    case REPAIR = 'repair';
    case SUPPLIER = 'supplier';
    case USER = 'user';

    public function entity(string|int $id): Model
    {
        return match ($this) {
            self::ADDRESS => Address::withTrashed()->findOrFail($id),
            self::BOOKING => Booking::withTrashed()->findOrFail($id),
            self::COMPANY => Company::withTrashed()->findOrFail($id),
            self::CONTACT => Contact::withTrashed()->findOrFail($id),
            self::CLIENT => Client::withTrashed()->findOrFail($id),
            self::FILE => File::withTrashed()->findOrFail($id),
            self::INVOICE => Invoice::withTrashed()->findOrFail($id),
            self::INVOICE_ITEM => InvoiceItem::withTrashed()->findOrFail($id),
            self::PRODUCT => Product::withTrashed()->findOrFail($id),
            self::REPAIR => Repair::withTrashed()->findOrFail($id),
            self::SUPPLIER => Supplier::withTrashed()->findOrFail($id),
            self::USER => User::withTrashed()->findOrFail($id),
        };
    }

    public function tableName(): string
    {
        return match($this) {
            self::ADDRESS => 'addresses',
            self::BOOKING => 'bookings',
            self::COMPANY => 'companies',
            self::CONTACT => 'contacts',
            self::CLIENT => 'clients',
            self::FILE => 'files',
            self::INVOICE => 'invoices',
            self::INVOICE_ITEM => 'invoice_items',
            self::PRODUCT => 'products',
            self::REPAIR => 'repairs',
            self::SUPPLIER => 'suppliers',
            self::USER => 'users',
        };
    }

    public function instance(): string
    {
        return match ($this) {
            self::ADDRESS => Address::class,
            self::BOOKING => Booking::class,
            self::COMPANY => Company::class,
            self::CONTACT => Contact::class,
            self::CLIENT => Client::class,
            self::FILE => File::class,
            self::INVOICE => Invoice::class,
            self::INVOICE_ITEM => InvoiceItem::class,
            self::PRODUCT => Product::class,
            self::REPAIR => Repair::class,
            self::SUPPLIER => Supplier::class,
            self::USER => User::class,
        };
    }

    /**
     * !!! Update the policy files as they are being created here
     */
    public function policy(): string
    {
        return match ($this) {
            self::ADDRESS => AddressPolicy::class,
            self::BOOKING => null,
            self::COMPANY => CompanyPolicy::class,
            self::CONTACT => null,
            self::CLIENT => null,
            self::FILE => null,
            self::INVOICE => null,
            self::INVOICE_ITEM => null,
            self::PRODUCT => null,
            self::REPAIR => null,
            self::SUPPLIER => SupplierPolicy::class,
            self::USER => UserPolicy::class,
        };
    }

    /**
     * !!! Update the request files as they are being created here
     */
    public function request(): stdClass
    {
        return (object) match ($this) {
            self::ADDRESS => [
                'store' => StoreAddressRequest::class,
                'update' => null,
            ],
            self::BOOKING => [
                'store' => StoreBookingRequest::class,
                'update' => UpdateBookingRequest::class,
            ],
            self::COMPANY => [
                'store' => StoreCompanyRequest::class,
                'update' => UpdateCompanyRequest::class,
            ],
            self::CONTACT => [
                'store' => StoreContactRequest::class,
                'update' => null,
            ],
            self::CLIENT => [
                'store' => StoreClientRequest::class,
                'update' => UpdateClientRequest::class,
            ],
            self::FILE => [
                'store' => StoreFileRequest::class,
                'update' => UpdateFileRequest::class,
            ],
            self::INVOICE => [
                'store' => StoreInvoiceRequest::class,
                'update' => UpdateInvoiceRequest::class,
            ],
            self::INVOICE_ITEM => [
                'store' => StoreInvoiceItemRequest::class,
                'update' => UpdateInvoiceItemRequest::class,
            ],
            self::PRODUCT => [
                'store' => StoreProductRequest::class,
                'update' => UpdateProductRequest::class,
            ],
            self::REPAIR => [
                'store' => StoreRepairRequest::class,
                'update' => null,
            ],
            self::SUPPLIER => [
                'store' => StoreSupplierRequest::class,
                'update' => UpdateSupplierRequest::class,
            ],
            self::USER => [
                'store' => StoreUserRequest::class,
                'update' => UpdateUserRequest::class,
            ],
        };
    }
}

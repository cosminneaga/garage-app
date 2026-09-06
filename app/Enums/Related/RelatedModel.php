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
use App\Http\Requests\StorePartRequest;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreWorkorderOperationLabourTimeRequest;
use App\Http\Requests\StoreWorkorderOperationRequest;
use App\Http\Requests\StoreWorkorderRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\UpdateInvoiceItemRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\UpdatePartRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateWorkorderOperationLabourTimeRequest;
use App\Http\Requests\UpdateWorkorderOperationRequest;
use App\Http\Requests\UpdateWorkorderRequest;
use App\Models\Address;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use App\Models\File;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Part;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Workorder;
use App\Models\WorkorderOperation;
use App\Models\WorkorderOperationLabourTime;
use App\Policies\AddressPolicy;
use App\Policies\BookingPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\ContactPolicy;
use App\Policies\PartPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkorderOperationLabourTimePolicy;
use App\Policies\WorkorderOperationPolicy;
use App\Policies\WorkorderPolicy;
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
    case SUPPLIER = 'supplier';
    case PART = 'part';
    case USER = 'user';
    case WORKORDER = 'workorder';
    case WORKORDER_OPERATION = 'workorder_operation';
    case WORKORDER_OPERATION_LABOUR_TIME = 'workorder_operation_labour_time';

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
            self::SUPPLIER => Supplier::withTrashed()->findOrFail($id),
            self::PART => Part::withTrashed()->findOrFail($id),
            self::USER => User::withTrashed()->findOrFail($id),
            self::WORKORDER => Workorder::withTrashed()->findOrFail($id),
            self::WORKORDER_OPERATION => WorkorderOperation::withTrashed()->findOrFail($id),
            self::WORKORDER_OPERATION_LABOUR_TIME => WorkorderOperationLabourTime::withTrashed()->findOrFail($id),
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
            self::SUPPLIER => 'suppliers',
            self::PART => 'parts',
            self::USER => 'users',
            self::WORKORDER => 'workorders',
            self::WORKORDER_OPERATION => 'workorder_operations',
            self::WORKORDER_OPERATION_LABOUR_TIME => 'workorder_operation_labour_times',
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
            self::SUPPLIER => Supplier::class,
            self::PART => Part::class,
            self::USER => User::class,
            self::WORKORDER => Workorder::class,
            self::WORKORDER_OPERATION => WorkorderOperation::class,
            self::WORKORDER_OPERATION_LABOUR_TIME => WorkorderOperationLabourTime::class,
        };
    }

    /**
     * !!! Update the policy files as they are being created here
     */
    public function policy(): string
    {
        return match ($this) {
            self::ADDRESS => AddressPolicy::class,
            self::BOOKING => BookingPolicy::class,
            self::COMPANY => CompanyPolicy::class,
            self::CONTACT => ContactPolicy::class,
            self::CLIENT => null,
            self::FILE => null,
            self::INVOICE => null,
            self::INVOICE_ITEM => null,
            self::SUPPLIER => SupplierPolicy::class,
            self::PART => PartPolicy::class,
            self::USER => UserPolicy::class,
            self::WORKORDER => WorkorderPolicy::class,
            self::WORKORDER_OPERATION => WorkorderOperationPolicy::class,
            self::WORKORDER_OPERATION_LABOUR_TIME => WorkorderOperationLabourTimePolicy::class,
        };
    }

    /**
     * !!! Update the request files as they are being created here
     */
    public function request(): object
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
            self::SUPPLIER => [
                'store' => StoreSupplierRequest::class,
                'update' => UpdateSupplierRequest::class,
            ],
            self::PART => [
                'store' => StorePartRequest::class,
                'update' => UpdatePartRequest::class,
            ],
            self::USER => [
                'store' => StoreUserRequest::class,
                'update' => UpdateUserRequest::class,
            ],
            self::WORKORDER => [
                'store' => StoreWorkorderRequest::class,
                'update' => UpdateWorkorderRequest::class,
            ],
            self::WORKORDER_OPERATION => [
                'store' => StoreWorkorderOperationRequest::class,
                'update' => UpdateWorkorderOperationRequest::class,
            ],
            self::WORKORDER_OPERATION_LABOUR_TIME => [
                'store' => StoreWorkorderOperationLabourTimeRequest::class,
                'update' => UpdateWorkorderOperationLabourTimeRequest::class,
            ],
        };
    }
}

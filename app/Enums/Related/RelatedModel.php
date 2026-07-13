<?php

declare(strict_types=1);

namespace App\Enums\Related;

use App\Models\Address;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\AddressPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Model;

enum RelatedModel: string
{
    case COMPANY = 'company';
    case SUPPLIER = 'supplier';
    case USER = 'user';
    case ADDRESS = 'address';

    public function entity(string|int $id): Model
    {
        return match ($this) {
            self::COMPANY => Company::findOrFail($id),
            self::SUPPLIER => Supplier::findOrFail($id),
            self::USER => User::findOrFail($id),
            self::ADDRESS => Address::findOrFail($id),
        };
    }

    public function tableName(): string
    {
        return match($this) {
            self::COMPANY => 'companies',
            self::SUPPLIER => 'suppliers',
            self::USER => 'users',
            self::ADDRESS => 'addresses',
        };
    }

    public function instance(): string
    {
        return match ($this) {
            self::COMPANY => Company::class,
            self::SUPPLIER => Supplier::class,
            self::USER => User::class,
            self::ADDRESS => Address::class,
        };
    }

    public function policy(): string
    {
        return match ($this) {
            self::COMPANY => CompanyPolicy::class,
            self::SUPPLIER => SupplierPolicy::class,
            self::USER => UserPolicy::class,
            self::ADDRESS => AddressPolicy::class,
        };
    }
}

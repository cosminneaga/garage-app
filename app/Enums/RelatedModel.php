<?php

declare(strict_types=1);

namespace App\Enums;

use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\CompanyPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Model;

enum RelatedModel: string
{
    case COMPANY = 'company';
    case SUPPLIER = 'supplier';
    case USER = 'user';

    public function entity(string|int $id): Model
    {
        return match ($this) {
            self::COMPANY => Company::findOrFail($id),
            self::SUPPLIER => Supplier::findOrFail($id),
            self::USER => User::findOrFail($id),
        };
    }

    public function instance(): string
    {
        return match ($this) {
            self::COMPANY => Company::class,
            self::SUPPLIER => Supplier::class,
            self::USER => User::class,
        };
    }

    public function policy(): string
    {
        return match ($this) {
            self::COMPANY => CompanyPolicy::class,
            self::SUPPLIER => SupplierPolicy::class,
            self::USER => UserPolicy::class,
        };
    }
}

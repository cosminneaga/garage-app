<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SupplierType;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Supplier extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'type',
        'tax_id',
        'registration_number',
    ];

    protected $casts = [
        'type' => SupplierType::class,
    ];

    protected $attributes = [
        'type' => SupplierType::DISTRIBUTOR->value,
    ];

    public function isMySupplier(User $user): bool
    {
        $company = $this->companies()->first();

        if ($user->hasRole(UserRole::USER_EDITOR)) {
            $manager = $user->managers()->first();

            return (bool) $company->users()->findOrFail($manager->id);
        }

        return (bool) $company->users()->findOrFail($user->id);
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function repairInvoiceItems(): HasMany
    {
        return $this->hasMany(RepairInvoiceItem::class);
    }
}

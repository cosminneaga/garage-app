<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SupplierType;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property SupplierType $type
 * @property string $tax_id
 * @property string $registration_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read Collection<int, \App\Models\RepairInvoiceItem> $repairInvoiceItems
 * @property-read int|null $repair_invoice_items_count
 * @method static \Database\Factories\SupplierFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withoutTrashed()
 * @mixin \Eloquent
 */
class Supplier extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

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
        if (! $user->roles()->exists()) {
            return false;
        }

        $company = $this->companies()->first();

        if ($user->hasRole(UserRole::USER_ADMIN)) {
            return (bool) $company->users()->find($user->id);
        }

        $manager = $user->managers()->first();
        if (! $manager) {
            return false;
        }

        return (bool) $company->users()->find($user->id);
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

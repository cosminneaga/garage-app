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

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property SupplierType $type
 * @property string $tax_id
 * @property string $registration_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RepairInvoiceItem> $repairInvoiceItems
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

    // !NOTE: this check is not quite right, rethink architecture
    // Also need to take in consideration admin actions over policy that implements this logic as guard
    // And, companies shouldn't be selected as first
    // Need to figure out a way to check if specific supplier belongs to given user
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

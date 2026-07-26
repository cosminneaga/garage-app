<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\SupplierFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\SupplierType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Throwable;

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
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, Company> $companies
 * @property-read int|null $companies_count
 * @property-read Collection<int, Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read Collection<int, RepairInvoiceItem> $repairInvoiceItems
 * @property-read int|null $repair_invoice_items_count
 * @method static SupplierFactory factory($count = null, $state = [])
 * @method static Builder<static>|Supplier newModelQuery()
 * @method static Builder<static>|Supplier newQuery()
 * @method static Builder<static>|Supplier onlyTrashed()
 * @method static Builder<static>|Supplier query()
 * @method static Builder<static>|Supplier whereCode($value)
 * @method static Builder<static>|Supplier whereCreatedAt($value)
 * @method static Builder<static>|Supplier whereDeletedAt($value)
 * @method static Builder<static>|Supplier whereId($value)
 * @method static Builder<static>|Supplier whereName($value)
 * @method static Builder<static>|Supplier whereRegistrationNumber($value)
 * @method static Builder<static>|Supplier whereTaxId($value)
 * @method static Builder<static>|Supplier whereType($value)
 * @method static Builder<static>|Supplier whereUpdatedAt($value)
 * @method static Builder<static>|Supplier withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Supplier withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperSupplier
 */
class Supplier extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Searchable;

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

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'tax_id' => $this->tax_id,
            'registration_number' => $this->registration_number,
        ];
    }

    public function isMySupplier(User $user): Throwable|bool
    {
        $company = $this->companies()->first();
        if (!$company) {
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

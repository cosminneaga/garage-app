<?php

declare(strict_types=1);

namespace App\Models;

use App\Policies\CompanyPolicy;
use App\Traits\Blameable;
use Database\Factories\CompanyFactory;
use Exception;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Throwable;

/**
 * @property int $id
 * @property string $name
 * @property string $tax_id
 * @property string $registration_number
 * @property float $tax_value
 * @property string $invoice_prefix
 * @property string|null $image_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, Client> $clients
 * @property-read int|null $clients_count
 * @property-read Collection<int, Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read User|null $creator
 * @property-read Collection<int, Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read User|null $updater
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static CompanyFactory factory($count = null, $state = [])
 * @method static Builder<static>|Company newModelQuery()
 * @method static Builder<static>|Company newQuery()
 * @method static Builder<static>|Company onlyTrashed()
 * @method static Builder<static>|Company query()
 * @method static Builder<static>|Company whereCreatedAt($value)
 * @method static Builder<static>|Company whereCreatedBy($value)
 * @method static Builder<static>|Company whereDeletedAt($value)
 * @method static Builder<static>|Company whereId($value)
 * @method static Builder<static>|Company whereImagePath($value)
 * @method static Builder<static>|Company whereInvoicePrefix($value)
 * @method static Builder<static>|Company whereName($value)
 * @method static Builder<static>|Company whereRegistrationNumber($value)
 * @method static Builder<static>|Company whereTaxId($value)
 * @method static Builder<static>|Company whereTaxValue($value)
 * @method static Builder<static>|Company whereUpdatedAt($value)
 * @method static Builder<static>|Company whereUpdatedBy($value)
 * @method static Builder<static>|Company withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Company withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperCompany
 */
#[UsePolicy(CompanyPolicy::class)]
class Company extends Model
{
    use HasFactory;
    use LogsActivity;
    use Searchable;
    use SoftDeletes;
    use Blameable;

    protected $fillable = [
        'name',
        'tax_id',
        'tax_value',
        'invoice_prefix',
        'registration_number',
        'image_path',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tax_value' => 'float',
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'tax_id' => $this->tax_id,
            'tax_value' => $this->tax_value,
            'registration_number' => $this->registration_number,
        ];
    }

    public function isMyCompany(User $user): Throwable|bool
    {
        if (! $user->roles()->exists()) {
            throw new Exception('The user must hold a valid role.');
        }

        return (bool) $this->users()->find($user->id);
    }

    public function findSupplierByName(string $name): ?Supplier
    {
        return $this->suppliers()->where('name', $name)->first();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class);
    }
}

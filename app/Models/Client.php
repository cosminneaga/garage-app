<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ClientObserver;
use App\Policies\ClientPolicy;
use App\Traits\Blameable;
use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Override;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $active
 * @property string|null $password
 * @property string|null $access_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\User|null $creator
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, Permission> $teams
 * @property-read int|null $teams_count
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static Builder<static>|Client newModelQuery()
 * @method static Builder<static>|Client newQuery()
 * @method static Builder<static>|Client onlyTrashed()
 * @method static Builder<static>|Client permission($permissions, bool $without = false)
 * @method static Builder<static>|Client query()
 * @method static Builder<static>|Client role($roles, ?string $guard = null, bool $without = false)
 * @method static Builder<static>|Client team($teams, bool $without = false)
 * @method static Builder<static>|Client whereAccessToken($value)
 * @method static Builder<static>|Client whereActive($value)
 * @method static Builder<static>|Client whereCreatedAt($value)
 * @method static Builder<static>|Client whereCreatedBy($value)
 * @method static Builder<static>|Client whereDeletedAt($value)
 * @method static Builder<static>|Client whereDeletedBy($value)
 * @method static Builder<static>|Client whereEmail($value)
 * @method static Builder<static>|Client whereId($value)
 * @method static Builder<static>|Client whereName($value)
 * @method static Builder<static>|Client wherePassword($value)
 * @method static Builder<static>|Client whereUpdatedAt($value)
 * @method static Builder<static>|Client whereUpdatedBy($value)
 * @method static Builder<static>|Client withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Client withoutPermission($permissions)
 * @method static Builder<static>|Client withoutRole($roles, ?string $guard = null)
 * @method static Builder<static>|Client withoutTeam($teams)
 * @method static Builder<static>|Client withoutTrashed()
 * @mixin \Eloquent
 */
#[UsePolicy(ClientPolicy::class)]
#[ObservedBy(ClientObserver::class)]
class Client extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;
    use Blameable;
    use Searchable;

    #[Override]
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->access_token = Str::random(64);
        });
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $attributes = [
        'active' => false,
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function isMyClient(User $user): bool
    {
        return (bool) $this
            ->join('client_company', 'client_company.client_id', '=', 'clients.id')
            ->join('company_user', 'company_user.company_id', '=', 'client_company.company_id')
            ->join('users', 'users.id', '=', 'company_user.user_id')
            ->where('client_company.client_id', $this->id)
            ->where('users.id', $user->id)
            ->exists();
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}

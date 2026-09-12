<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Policies\UserPolicy;
use App\Traits\Blameable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
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
 * @property Carbon|null $email_verified_at
 * @property string|null $image_path
 * @property string $password
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $remember_token
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, Company> $companies
 * @property-read int|null $companies_count
 * @property-read Collection<int, Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read User|null $creator
 * @property-read Collection<int, User> $managers
 * @property-read int|null $managers_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, Permission> $teams
 * @property-read int|null $teams_count
 * @property-read User|null $updater
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User onlyTrashed()
 * @method static Builder<static>|User permission($permissions, bool $without = false)
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static Builder<static>|User team($teams, bool $without = false)
 * @method static Builder<static>|User whereActive($value)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereCreatedBy($value)
 * @method static Builder<static>|User whereDeletedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereImagePath($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User whereUpdatedBy($value)
 * @method static Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|User withoutPermission($permissions)
 * @method static Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static Builder<static>|User withoutTeam($teams)
 * @method static Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperUser
 */
#[UsePolicy(UserPolicy::class)]
class User extends Authenticatable
{
    use Blameable;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use Searchable;
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'image_path',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'active' => false,
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'active' => $this->active,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
        ];
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isSuper(): bool
    {
        return $this->hasRole(UserRole::SUPER);
    }

    public function isAdministrator(): bool
    {
        return $this->hasRole(UserRole::ADMINISTRATOR);
    }

    public function isManager(): bool
    {
        return $this->hasRole(UserRole::MANAGER);
    }

    public function isUser(): bool
    {
        return $this->hasRole(UserRole::USER);
    }

    public function chart(): array
    {
        $data = $this->select('created_at as date', DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'date' => collect($data)->pluck('date')->toArray(),
            'count' => collect($data)->pluck('count')->toArray(),
        ];
    }

    /**
     * !! To be used from top-bottom approach
     * managers -> users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'team_manager_users',
            'manager_id',
            'user_id',
        );
    }

    /**
     * !! To be used from top-bottom approach
     */
    public function memberDetach(User $user): void
    {
        if ($this->isAdministrator()) {
            return;
        }

        if ($this->isManager()) {
            $this->users()->detach($user);

            return;
        }
    }

    /**
     * !! To be used from top-bottom approach
     */
    public function memberAttach(User $user): void
    {
        if ($this->isAdministrator()) {
            return;
        }

        if ($this->isManager()) {
            $this->users()->attach($user);

            return;
        }
    }

    /**
     * !! To be used from top-bottom approach
     */
    public function isMyUser(User $user): bool
    {
        if ($this->isAdministrator()) {
            return User::whereKey($user->id)
                ->whereHas('roles', fn ($query) => $query->where('name', UserRole::USER->value))
                ->exists();
        }

        // need to fetch only attached users
        return $this->users()->whereKey($user->id)->exists();
    }

    /**
     * !! To be used from top-bottom approach
     */
    public function isMyManager(User $user): bool
    {
        return User::whereKey($user->id)
            ->whereHas('roles', fn ($query) => $query->where('name', UserRole::MANAGER->value))
            ->exists();
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }

    // !!! watch these for errors when called
    public function bookingsAdvised(): HasMany
    {
        return $this->hasMany(Booking::class, 'advisor_id', 'id');
    }

    public function woAssigned(): HasMany
    {
        return $this->hasMany(Workorder::class, 'technician_id', 'id');
    }

    public function woOperationAssigned(): HasMany
    {
        return $this->hasMany(WorkorderOperation::class, 'performed_by', 'id');
    }
}

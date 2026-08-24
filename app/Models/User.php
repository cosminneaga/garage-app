<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Policies\UserPolicy;
use App\Traits\Blameable;
use Database\Factories\UserFactory;
use Exception;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Throwable;

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

    /**
     * Functions one-way from manager to users & one-way through from administrator to user
     */
    public function isMyUser(User $user): Throwable|bool
    {
        if (Auth::check() && Auth::user()->id === $user->id) {
            return true;
        }

        if (!$this->hasAnyRole(
            UserRole::MANAGER->value,
            UserRole::ADMINISTRATOR->value,
            UserRole::USER->value
        )) {
            throw new Exception('The user must hold a valid role');
        }

        if ($this->isAdministrator()) {
            if ($user->isManager()) {
                return $this
                    ->managers()
                    ->where('users.id', $user->id)
                    ->withTrashed()
                    ->exists();
            }
            if ($user->isUser()) {
                return $this->join('team_manager_users', 'team_manager_users.user_id', '=', 'users.id')
                ->join('team_administrator_managers', 'team_administrator_managers.manager_id', '=', 'team_manager_users.manager_id')
                ->where('team_administrator_managers.administrator_id', $this->id)
                ->where('users.id', $user->id)
                ->withTrashed()
                ->exists();
            }
        }

        if ($this->isManager()) {
            return $this
                ->users()
                ->where('users.id', $user->id)
                ->withTrashed()
                ->exists();
        }

        // !!! This could fail if there are multiple managers, as it takes the first one only
        // Have a workarund for future, with tests
        if (count($this->managers) > 0) {
            return $this->join('team_manager_users', 'team_manager_users.user_id', '=', 'users.id')
                ->where('team_manager_users.manager_id', '=', $this->managers->first()->id)
                ->where('users.id', $user->id)
                ->withTrashed()
                ->exists();
        }

        return false;
    }

    public function isMyManager(User $user): Throwable|bool
    {
        if (!$this->hasRole(UserRole::ADMINISTRATOR)) {
            throw new Exception('User data can only be access by an administrator');
        }

        return $this
            ->managers()
            ->where('users.id', $user->id)
            ->withTrashed()
            ->exists();
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
     * Functions two-ways as from administrator to managers, and from user to managers
     */
    public function managers(): BelongsToMany
    {
        if ($this->isAdministrator()) {
            return $this->belongsToMany(
                User::class,
                'team_administrator_managers',
                'administrator_id',
                'manager_id',
            );
        }

        return $this->belongsToMany(
            User::class,
            'team_manager_users',
            'user_id',
            'manager_id',
        );
    }

    /**
     * Functions one-way from manager to users
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

    public function memberAttach(User $user): void
    {
        if ($user->isManager()) {
            $this->managers()->attach($user);
        } elseif ($user->isUser()) {
            $this->users()->attach($user);
        }
    }

    public function memberDetach(User $user): void
    {
        if ($user->isManager()) {
            $this->managers()->detach($user);
        } elseif ($user->isUser()) {
            $this->users()->detach($user);
        }
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
}

<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Blameable;
use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
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
 * @property string $password
 * @property string|null $access_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, Company> $companies
 * @property-read int|null $companies_count
 * @property-read Collection<int, Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read User|null $creator
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, Permission> $teams
 * @property-read int|null $teams_count
 * @property-read User|null $updater
 * @method static ClientFactory factory($count = null, $state = [])
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
 * @mixin IdeHelperClient
 */
class Client extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;
    use Blameable;

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
}

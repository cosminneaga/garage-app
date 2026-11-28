<?php

declare(strict_types=1);

namespace App\Models;

use Override;
use App\Observers\ClientObserver;
use App\Policies\ClientPolicy;
use App\Traits\Blameable;
use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $active
 * @property Carbon|null $email_verified_at
 * @property string|null $image_path
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $address_id
 * @property int|null $contact_id
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Address|null $address
 * @property-read Collection<int, Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read Collection<int, Company> $companies
 * @property-read int|null $companies_count
 * @property-read Contact|null $contact
 * @property-read Model|\Eloquent|null $createdByActor
 * @property-read \App\Models\User|null $creator
 * @property-read Model|\Eloquent|null $deletedByActor
 * @property-read \App\Models\User|null $deletor
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Model|\Eloquent|null $updatedByActor
 * @property-read \App\Models\User|null $updater
 * @property-read Collection<int, Workorder> $workorders
 * @property-read int|null $workorders_count
 * @method static ClientFactory factory($count = null, $state = [])
 * @method static Builder<static>|Client newModelQuery()
 * @method static Builder<static>|Client newQuery()
 * @method static Builder<static>|Client onlyTrashed()
 * @method static Builder<static>|Client query()
 * @method static Builder<static>|Client whereActive($value)
 * @method static Builder<static>|Client whereAddressId($value)
 * @method static Builder<static>|Client whereContactId($value)
 * @method static Builder<static>|Client whereCreatedAt($value)
 * @method static Builder<static>|Client whereCreatedBy($value)
 * @method static Builder<static>|Client whereDeletedAt($value)
 * @method static Builder<static>|Client whereDeletedBy($value)
 * @method static Builder<static>|Client whereEmail($value)
 * @method static Builder<static>|Client whereEmailVerifiedAt($value)
 * @method static Builder<static>|Client whereId($value)
 * @method static Builder<static>|Client whereImagePath($value)
 * @method static Builder<static>|Client whereName($value)
 * @method static Builder<static>|Client wherePassword($value)
 * @method static Builder<static>|Client whereRememberToken($value)
 * @method static Builder<static>|Client whereUpdatedAt($value)
 * @method static Builder<static>|Client whereUpdatedBy($value)
 * @method static Builder<static>|Client withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Client withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperClient
 */
#[UsePolicy(ClientPolicy::class)]
#[ObservedBy(ClientObserver::class)]
#[Fillable([
    'name',
    'email',
    'password',
    'active',
    'image_path',
    'created_by',
    'updated_by',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class Client extends Authenticatable
{
    use HasFactory;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;
    use Blameable;
    use Searchable;

    #[Override]
    protected $attributes = [
        'active' => true,
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
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

    public function isMyBooking(Booking $booking): bool
    {
        return (bool) $this->bookings()->find($booking)->first();
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function workorders(): HasMany
    {
        return $this->hasMany(Workorder::class);
    }
}

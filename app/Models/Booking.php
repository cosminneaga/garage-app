<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\FormattedDateTime;
use App\Enums\Priority;
use App\Enums\Status\BookingStatus;
use App\Enums\Type\ServiceType;
use App\Enums\UserRole;
use App\Observers\BookingObserver;
use App\Policies\BookingPolicy;
use App\Traits\Blameable;
use Database\Factories\BookingFactory;
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
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use LogicException;
use Override;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string|null $number
 * @property BookingStatus $status
 * @property ServiceType $service_type
 * @property Priority $priority
 * @property Carbon|null $start
 * @property Carbon|null $finish
 * @property int|null $estimated_duration_minutes
 * @property string|null $current_status_info
 * @property string|null $complaint
 * @property string|null $notes
 * @property float $estimated_cost
 * @property Carbon|null $reminder_sent_at
 * @property Carbon|null $checked_in_at
 * @property Carbon|null $cancelled_at
 * @property Carbon|null $completed_at
 * @property Carbon|null $in_review_at
 * @property Carbon|null $in_progress_at
 * @property string|null $client_notes
 * @property string|null $client_url_token
 * @property int $company_id
 * @property int $client_id
 * @property int $vehicle_id
 * @property int $advisor_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read User|null $advisor
 * @property-read Client|null $client
 * @property-read Collection<int, File> $clientFiles
 * @property-read int|null $client_files_count
 * @property-read Company|null $company
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read Vehicle|null $vehicle
 * @property-read Collection<int, Workorder> $workorders
 * @property-read int|null $workorders_count
 * @method static BookingFactory factory($count = null, $state = [])
 * @method static Builder<static>|Booking newModelQuery()
 * @method static Builder<static>|Booking newQuery()
 * @method static Builder<static>|Booking onlyTrashed()
 * @method static Builder<static>|Booking query()
 * @method static Builder<static>|Booking whereAdvisorId($value)
 * @method static Builder<static>|Booking whereAppointmentFinish($value)
 * @method static Builder<static>|Booking whereAppointmentStart($value)
 * @method static Builder<static>|Booking whereCancelledAt($value)
 * @method static Builder<static>|Booking whereCheckedInAt($value)
 * @method static Builder<static>|Booking whereClientId($value)
 * @method static Builder<static>|Booking whereClientNotes($value)
 * @method static Builder<static>|Booking whereClientUrlToken($value)
 * @method static Builder<static>|Booking whereCompanyId($value)
 * @method static Builder<static>|Booking whereComplaint($value)
 * @method static Builder<static>|Booking whereCompletedAt($value)
 * @method static Builder<static>|Booking whereCreatedAt($value)
 * @method static Builder<static>|Booking whereCreatedBy($value)
 * @method static Builder<static>|Booking whereCurrentStatusInfo($value)
 * @method static Builder<static>|Booking whereDeletedAt($value)
 * @method static Builder<static>|Booking whereDeletedBy($value)
 * @method static Builder<static>|Booking whereEstimatedCost($value)
 * @method static Builder<static>|Booking whereEstimatedDurationMinutes($value)
 * @method static Builder<static>|Booking whereId($value)
 * @method static Builder<static>|Booking whereInProgressAt($value)
 * @method static Builder<static>|Booking whereInReviewAt($value)
 * @method static Builder<static>|Booking whereNotes($value)
 * @method static Builder<static>|Booking whereNumber($value)
 * @method static Builder<static>|Booking wherePriority($value)
 * @method static Builder<static>|Booking whereReminderSentAt($value)
 * @method static Builder<static>|Booking whereServiceType($value)
 * @method static Builder<static>|Booking whereStatus($value)
 * @method static Builder<static>|Booking whereUpdatedAt($value)
 * @method static Builder<static>|Booking whereUpdatedBy($value)
 * @method static Builder<static>|Booking whereVehicleId($value)
 * @method static Builder<static>|Booking withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Booking withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperBooking
 */
#[UsePolicy(BookingPolicy::class)]
#[ObservedBy(BookingObserver::class)]
class Booking extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use Searchable;

    #[Override]
    protected static function booted(): void
    {
        static::created(function ($model) {
            $model->number = sprintf('BK-%s-%d', now()->timestamp, $model->id);
            $model->client_url_token = sprintf('%s%d', now()->timestamp, random_int(1000, 9999));
            $model->saveQuietly();
        });

        static::updating(function ($model) {
            if (
                $model->isDirty('completed_at') &&
                $model->getOriginal('completed_at') !== null
            ) {
                throw new LogicException('completed_at can only be set once');
            }
        });
    }

    protected $fillable = [
        'service_type',
        'priority',
        'estimated_duration_minutes',
        'current_status_info',
        'complaint',
        'notes',
        'client_notes',
        'estimated_cost',
        'confirmed_at',
        'checked_in_at',
        'cancelled_at',
        'completed_at',
    ];

    protected $casts = [
        'confirmed_at' => FormattedDateTime::class,
        'reminder_sent_at' => FormattedDateTime::class,
        'checked_in_at' => FormattedDateTime::class,
        'completed_at' => FormattedDateTime::class,
        'cancelled_at' => FormattedDateTime::class,
        'in_review_at' => FormattedDateTime::class,
        'in_progress_at' => FormattedDateTime::class,
        'estimated_cost' => 'float',
        'status' => BookingStatus::class,
        'service_type' => ServiceType::class,
        'priority' => Priority::class,
    ];

    protected $attributes = [
        'status' => BookingStatus::PENDING->value,
        'service_type' => ServiceType::SERVICE->value,
        'priority' => Priority::LOW->value,
    ];

    public function toSearchableArray(): array
    {
        return [
            'number' => $this->number,
            'status' => $this->status,
            'service_type' => $this->service_type,
            'priority' => $this->priority,
            'confirmed_at' => $this->confirmed_at,
        ];
    }

    public function isPartOfMyCompany(User $user): bool
    {
        return (bool) $this->company->users()->find($user->id);
    }

    public function isMine(User $user): bool
    {
        if ($user->hasAnyRole([UserRole::ADMINISTRATOR->value, UserRole::MANAGER->value])) {
            return $this->isPartOfMyCompany($user);
        }

        return (bool) $this->advisor_id === $user->id;
    }

    public function availableTechnicians(): BelongsToMany
    {
        return $this->company->users()->role([UserRole::MANAGER, UserRole::USER]);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clientFiles(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }

    public function workorders(): HasMany
    {
        return $this->hasMany(Workorder::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(BookingStatusHistory::class);
    }
}

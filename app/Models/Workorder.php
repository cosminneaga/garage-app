<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\FormattedDateTime;
use App\Enums\Status\WorkorderStatus;
use App\Enums\UserRole;
use App\Observers\WorkorderObserver;
use App\Traits\Blameable;
use Database\Factories\WorkorderFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Override;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $title
 * @property string|null $number
 * @property WorkorderStatus $status
 * @property int|null $odometer_on_start
 * @property int|null $odometer_on_finish
 * @property string|null $complaint
 * @property string|null $initial_inspection_notes
 * @property string|null $notes
 * @property string|null $part_notes
 * @property numeric $labour_price_hourly
 * @property numeric $labour_total_cost
 * @property numeric $part_total_cost
 * @property Carbon|null $completed_at
 * @property Carbon|null $cancelled_at
 * @property Carbon|null $in_progress_at
 * @property Carbon|null $in_pause_at
 * @property int $booking_id
 * @property int $technician_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Booking|null $booking
 * @property-read User|null $creator
 * @property-read Collection<int, File> $files
 * @property-read int|null $files_count
 * @property-read Collection<int, WorkorderOperation> $operations
 * @property-read int|null $operations_count
 * @property-read Collection<int, WorkorderStatusHistory> $statuses
 * @property-read int|null $statuses_count
 * @property-read User|null $technician
 * @property-read User|null $updater
 * @method static WorkorderFactory factory($count = null, $state = [])
 * @method static Builder<static>|Workorder newModelQuery()
 * @method static Builder<static>|Workorder newQuery()
 * @method static Builder<static>|Workorder onlyTrashed()
 * @method static Builder<static>|Workorder query()
 * @method static Builder<static>|Workorder whereBookingId($value)
 * @method static Builder<static>|Workorder whereCancelledAt($value)
 * @method static Builder<static>|Workorder whereComplaint($value)
 * @method static Builder<static>|Workorder whereCompletedAt($value)
 * @method static Builder<static>|Workorder whereCreatedAt($value)
 * @method static Builder<static>|Workorder whereCreatedBy($value)
 * @method static Builder<static>|Workorder whereDeletedAt($value)
 * @method static Builder<static>|Workorder whereDeletedBy($value)
 * @method static Builder<static>|Workorder whereId($value)
 * @method static Builder<static>|Workorder whereInPauseAt($value)
 * @method static Builder<static>|Workorder whereInProgressAt($value)
 * @method static Builder<static>|Workorder whereInitialInspectionNotes($value)
 * @method static Builder<static>|Workorder whereLabourPriceHourly($value)
 * @method static Builder<static>|Workorder whereLabourTotalCost($value)
 * @method static Builder<static>|Workorder whereNotes($value)
 * @method static Builder<static>|Workorder whereNumber($value)
 * @method static Builder<static>|Workorder whereOdometerOnFinish($value)
 * @method static Builder<static>|Workorder whereOdometerOnStart($value)
 * @method static Builder<static>|Workorder wherePartNotes($value)
 * @method static Builder<static>|Workorder wherePartTotalCost($value)
 * @method static Builder<static>|Workorder whereStatus($value)
 * @method static Builder<static>|Workorder whereTechnicianId($value)
 * @method static Builder<static>|Workorder whereTitle($value)
 * @method static Builder<static>|Workorder whereUpdatedAt($value)
 * @method static Builder<static>|Workorder whereUpdatedBy($value)
 * @method static Builder<static>|Workorder withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Workorder withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperWorkorder
 */
#[ObservedBy(WorkorderObserver::class)]
class Workorder extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    #[Override]
    protected static function booted(): void
    {
        static::created(function ($model) {
            $model->number = sprintf('WO-%s-%d', now()->timestamp, $model->id);
            $model->saveQuietly();
        });
    }

    protected $fillable = [
        'title',
        'status',
        'odometer_on_start',
        'odometer_on_finish',
        'complaint',
        'initial_inspection_notes',
        'notes',
        'part_notes',
        'labour_price_hourly',
        'labour_total_cost',
        'part_total_cost',
    ];

    protected $casts = [
        'status' => WorkorderStatus::class,
        'completed_at' => FormattedDateTime::class,
        'cancelled_at' => FormattedDateTime::class,
        'in_progress_at' => FormattedDateTime::class,
        'in_pause_at' => FormattedDateTime::class,
    ];

    protected $attributes = [
        'status' => WorkorderStatus::PENDING->value,
    ];

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'number' => $this->number,
            'status' => $this->status,
        ];
    }

    public function isPartOfMyCompany(User $user): bool
    {
        return (bool) $this->booking->company->users()->find($user->id);
    }

    public function isPartOfMyBooking(User $user): bool
    {
        if ($user->hasAnyRole([UserRole::ADMINISTRATOR->value, UserRole::MANAGER->value])) {
            return $this->isPartOfMyCompany($user);
        }

        return (bool) $this->booking->advisor_id === $user->id;
    }

    public function isMine(User $user): bool
    {
        if ($user->hasAnyRole([UserRole::ADMINISTRATOR->value, UserRole::MANAGER->value])) {
            return $this->isPartOfMyCompany($user);
        }

        return (bool) $this->technician_id === $user->id;
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function operations(): HasMany
    {
        return $this->hasMany(WorkorderOperation::class);
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(WorkorderStatusHistory::class);
    }
}

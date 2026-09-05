<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\WorkorderStatus;
use App\Observers\WorkorderObserver;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Override;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $title
 * @property int $number
 * @property string $status
 * @property int|null $odometer_on_start
 * @property int|null $odometer_on_finish
 * @property string|null $complaint
 * @property string|null $initial_inspection_notes
 * @property string|null $notes
 * @property string|null $part_notes
 * @property numeric $labour_price_hourly
 * @property numeric $labour_total_cost
 * @property numeric $part_total_cost
 * @property int $technician_id
 * @property int $booking_id
 * @property int $company_id
 * @property int $assigned_by
 * @property int $vehicle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @method static Builder<static>|Workorder newModelQuery()
 * @method static Builder<static>|Workorder newQuery()
 * @method static Builder<static>|Workorder onlyTrashed()
 * @method static Builder<static>|Workorder query()
 * @method static Builder<static>|Workorder whereAssignedBy($value)
 * @method static Builder<static>|Workorder whereBookingId($value)
 * @method static Builder<static>|Workorder whereCompanyId($value)
 * @method static Builder<static>|Workorder whereComplaint($value)
 * @method static Builder<static>|Workorder whereCreatedAt($value)
 * @method static Builder<static>|Workorder whereCreatedBy($value)
 * @method static Builder<static>|Workorder whereDeletedAt($value)
 * @method static Builder<static>|Workorder whereId($value)
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
 * @method static Builder<static>|Workorder whereVehicleId($value)
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

    public function isMyWorkorder(User $user): bool
    {
        return (bool) $this->booking->company->users()->find($user->id);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function operation(): HasMany
    {
        return $this->hasMany(WorkorderOperation::class);
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }
}

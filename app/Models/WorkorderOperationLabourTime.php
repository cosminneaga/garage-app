<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\FormattedDateTime;
use App\Observers\WorkorderOperationLabourTimeObserver;
use App\Traits\Blameable;
use Database\Factories\WorkorderOperationLabourTimeFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $start
 * @property \Illuminate\Support\Carbon|null $end
 * @property int $workorder_operation_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read User|null $creator
 * @property-read WorkorderOperation|null $operation
 * @property-read User|null $updater
 * @method static WorkorderOperationLabourTimeFactory factory($count = null, $state = [])
 * @method static Builder<static>|WorkorderOperationLabourTime newModelQuery()
 * @method static Builder<static>|WorkorderOperationLabourTime newQuery()
 * @method static Builder<static>|WorkorderOperationLabourTime onlyTrashed()
 * @method static Builder<static>|WorkorderOperationLabourTime query()
 * @method static Builder<static>|WorkorderOperationLabourTime whereCreatedAt($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereCreatedBy($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereDeletedAt($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereDeletedBy($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereEnd($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereId($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereStart($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereUpdatedAt($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereUpdatedBy($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereWorkorderOperationId($value)
 * @method static Builder<static>|WorkorderOperationLabourTime withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|WorkorderOperationLabourTime withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperWorkorderOperationLabourTime
 */
#[ObservedBy(WorkorderOperationLabourTimeObserver::class)]
class WorkorderOperationLabourTime extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'start',
        'end',
    ];

    protected $casts = [
        'start' => FormattedDateTime::class,
        'end' => FormattedDateTime::class,
    ];

    protected static function booted()
    {
        static::creating(function (WorkorderOperationLabourTime $time) {
            $time->start ??= Carbon::now();
        });

        static::updating(function (WorkorderOperationLabourTime $time) {
            $start = Carbon::parse($time->start);
            $end = Carbon::parse($time->end);
            $time->minutes = $start->diffInMinutes($end);
        });
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(WorkorderOperation::class, 'workorder_operation_id', 'id');
    }
}

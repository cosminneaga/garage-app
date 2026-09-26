<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
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
 * @property $start
 * @property $end
 * @property int|null $minutes
 * @property int $workorder_operation_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $deletor
 * @property-read \App\Models\WorkorderOperation|null $operation
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\WorkorderOperationLabourTimeFactory factory($count = null, $state = [])
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
 * @method static Builder<static>|WorkorderOperationLabourTime whereMinutes($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereStart($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereUpdatedAt($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereUpdatedBy($value)
 * @method static Builder<static>|WorkorderOperationLabourTime whereWorkorderOperationId($value)
 * @method static Builder<static>|WorkorderOperationLabourTime withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|WorkorderOperationLabourTime withoutTrashed()
 * @mixin \Eloquent
 */
#[ObservedBy(WorkorderOperationLabourTimeObserver::class)]
#[Fillable([
    'start',
    'end',
])]
class WorkorderOperationLabourTime extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

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
    protected function casts(): array
    {
        return [
            'start' => FormattedDateTime::class,
            'end' => FormattedDateTime::class,
        ];
    }
}

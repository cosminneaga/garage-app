<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\WorkorderOperationLabourTimeObserver;
use App\Traits\Blameable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\WorkorderOperation|null $workorderOperation
 * @method static \Database\Factories\WorkorderOperationLabourTimeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime whereWorkorderOperationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperationLabourTime withoutTrashed()
 * @mixin \Eloquent
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
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function (WorkorderOperationLabourTime $time) {
            $time->start ??= Carbon::now();
        });
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(WorkorderOperation::class, 'workorder_operation_id', 'id');
    }
}

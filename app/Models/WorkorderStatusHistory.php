<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Status\WorkorderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $status
 * @property string|null $description
 * @property int $workorder_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Workorder|null $workorder
 * @method static Builder<static>|WorkorderStatusHistory newModelQuery()
 * @method static Builder<static>|WorkorderStatusHistory newQuery()
 * @method static Builder<static>|WorkorderStatusHistory onlyTrashed()
 * @method static Builder<static>|WorkorderStatusHistory query()
 * @method static Builder<static>|WorkorderStatusHistory whereCreatedAt($value)
 * @method static Builder<static>|WorkorderStatusHistory whereDescription($value)
 * @method static Builder<static>|WorkorderStatusHistory whereId($value)
 * @method static Builder<static>|WorkorderStatusHistory whereStatus($value)
 * @method static Builder<static>|WorkorderStatusHistory whereUpdatedAt($value)
 * @method static Builder<static>|WorkorderStatusHistory whereWorkorderId($value)
 * @method static Builder<static>|WorkorderStatusHistory withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|WorkorderStatusHistory withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperWorkorderStatusHistory
 */
class WorkorderStatusHistory extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'status',
        'description',
    ];

    protected $attributes = [
        'status' => WorkorderStatus::class,
    ];

    public function workorder(): BelongsTo
    {
        return $this->belongsTo(Workorder::class);
    }
}

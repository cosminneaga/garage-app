<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Database\Factories\FileFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\FileStatus;
use App\Enums\RepairStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property FileStatus $status
 * @property RepairStatus $repair_status
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Repair|null $repair
 * @method static FileFactory factory($count = null, $state = [])
 * @method static Builder<static>|File newModelQuery()
 * @method static Builder<static>|File newQuery()
 * @method static Builder<static>|File onlyTrashed()
 * @method static Builder<static>|File query()
 * @method static Builder<static>|File withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|File withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperFile
 */
class File extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'extension',
        'path',
        'type',
        'status',
        'repair_status',
        'description',
    ];

    protected $casts = [
        'status' => FileStatus::class,
        'repair_status' => RepairStatus::class,
    ];

    protected $attributes = [
        'status' => FileStatus::BEFORE->value,
        'repair_status' => RepairStatus::RECEPTION->value,
    ];

    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class);
    }
}

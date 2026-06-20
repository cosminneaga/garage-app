<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\RepairFileFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\FileStatus;
use App\Enums\RepairStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property string $path
 * @property string $type
 * @property FileStatus $status
 * @property RepairStatus $repair_status
 * @property string|null $description
 * @property int $repair_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Repair|null $repair
 * @method static RepairFileFactory factory($count = null, $state = [])
 * @method static Builder<static>|RepairFile newModelQuery()
 * @method static Builder<static>|RepairFile newQuery()
 * @method static Builder<static>|RepairFile onlyTrashed()
 * @method static Builder<static>|RepairFile query()
 * @method static Builder<static>|RepairFile whereCreatedAt($value)
 * @method static Builder<static>|RepairFile whereDeletedAt($value)
 * @method static Builder<static>|RepairFile whereDescription($value)
 * @method static Builder<static>|RepairFile whereExtension($value)
 * @method static Builder<static>|RepairFile whereId($value)
 * @method static Builder<static>|RepairFile whereName($value)
 * @method static Builder<static>|RepairFile wherePath($value)
 * @method static Builder<static>|RepairFile whereRepairId($value)
 * @method static Builder<static>|RepairFile whereRepairStatus($value)
 * @method static Builder<static>|RepairFile whereStatus($value)
 * @method static Builder<static>|RepairFile whereType($value)
 * @method static Builder<static>|RepairFile whereUpdatedAt($value)
 * @method static Builder<static>|RepairFile withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|RepairFile withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperRepairFile
 */
class RepairFile extends Model
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

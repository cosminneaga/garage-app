<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FileStatus;
use App\Enums\RepairStatus;
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
 *
 * @method static \Database\Factories\RepairFileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereRepairId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereRepairStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile withoutTrashed()
 *
 * @mixin \Eloquent
 */
class RepairFile extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

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

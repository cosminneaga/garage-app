<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FileType;
use App\Enums\RepairStatus;
use App\Traits\Blameable;
use Database\Factories\FileFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property FileType $status
 * @property RepairStatus $repair_status
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
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
    use Blameable;

    protected $fillable = [
        'name',
        'extension',
        'path',
        'type',
        'description',
    ];

    protected $casts = [
        'type' => FileType::class,
    ];

    protected $attributes = [
        'type' => FileType::OTHER->value,
    ];
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Carbon;
use App\Enums\Type\FileType;
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
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property string $path
 * @property FileType $type
 * @property string|null $description
 * @property int $uploaded_by
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read User|null $creator
 * @property-read User|null $deletor
 * @property-read User|null $updater
 * @method static FileFactory factory($count = null, $state = [])
 * @method static Builder<static>|File newModelQuery()
 * @method static Builder<static>|File newQuery()
 * @method static Builder<static>|File onlyTrashed()
 * @method static Builder<static>|File query()
 * @method static Builder<static>|File whereCreatedAt($value)
 * @method static Builder<static>|File whereCreatedBy($value)
 * @method static Builder<static>|File whereDeletedAt($value)
 * @method static Builder<static>|File whereDeletedBy($value)
 * @method static Builder<static>|File whereDescription($value)
 * @method static Builder<static>|File whereExtension($value)
 * @method static Builder<static>|File whereId($value)
 * @method static Builder<static>|File whereName($value)
 * @method static Builder<static>|File wherePath($value)
 * @method static Builder<static>|File whereType($value)
 * @method static Builder<static>|File whereUpdatedAt($value)
 * @method static Builder<static>|File whereUpdatedBy($value)
 * @method static Builder<static>|File whereUploadedBy($value)
 * @method static Builder<static>|File withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|File withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperFile
 */
#[Fillable([
    'name',
    'extension',
    'path',
    'type',
    'description',
])]
class File extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Blameable;

    protected $attributes = [
        'type' => FileType::OTHER->value,
    ];
    protected function casts(): array
    {
        return [
            'type' => FileType::class,
        ];
    }
}

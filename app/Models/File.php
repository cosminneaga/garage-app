<?php

declare(strict_types=1);

namespace App\Models;

use Override;
use App\Enums\Type\FileType;
use App\Traits\Blameable;
use Database\Factories\FileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property FileType $type
 * @property string|null $description
 * @property string $name
 * @property string $mime
 * @property string $path
 * @property int|null $created_by
 * @property string|null $created_by_type
 * @property int|null $updated_by
 * @property string|null $updated_by_type
 * @property int|null $deleted_by
 * @property string|null $deleted_by_type
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Model|\Eloquent|null $createdByActor
 * @property-read User|null $creator
 * @property-read Model|\Eloquent|null $deletedByActor
 * @property-read User|null $deletor
 * @property-read Model|\Eloquent|null $updatedByActor
 * @property-read User|null $updater
 * @method static FileFactory factory($count = null, $state = [])
 * @method static Builder<static>|File newModelQuery()
 * @method static Builder<static>|File newQuery()
 * @method static Builder<static>|File onlyTrashed()
 * @method static Builder<static>|File query()
 * @method static Builder<static>|File whereCreatedAt($value)
 * @method static Builder<static>|File whereCreatedBy($value)
 * @method static Builder<static>|File whereCreatedByType($value)
 * @method static Builder<static>|File whereDeletedAt($value)
 * @method static Builder<static>|File whereDeletedBy($value)
 * @method static Builder<static>|File whereDeletedByType($value)
 * @method static Builder<static>|File whereDescription($value)
 * @method static Builder<static>|File whereId($value)
 * @method static Builder<static>|File whereMime($value)
 * @method static Builder<static>|File whereName($value)
 * @method static Builder<static>|File wherePath($value)
 * @method static Builder<static>|File whereType($value)
 * @method static Builder<static>|File whereUpdatedAt($value)
 * @method static Builder<static>|File whereUpdatedBy($value)
 * @method static Builder<static>|File whereUpdatedByType($value)
 * @method static Builder<static>|File withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|File withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperFile
 */
#[Fillable([
    'name',
    'mime',
    'path',
    'type',
    'description',
    'uploaded_by',
    'uploaded_by_type',
])]
class File extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Blameable;

    #[Override]
    protected $attributes = [
        'type' => FileType::OTHER->value,
    ];

    protected function casts(): array
    {
        return [
            'type' => FileType::class,
        ];
    }

    public function usesPolymorphicBlame(): bool
    {
        return true;
    }
}

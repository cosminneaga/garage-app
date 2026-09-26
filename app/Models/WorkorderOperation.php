<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Enums\Type\WorkorderOperationType;
use App\Enums\UserRole;
use App\Traits\Blameable;
use Database\Factories\WorkorderOperationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property WorkorderOperationType $type
 * @property int|null $part_installed_odometer
 * @property int|null $expected_life_km
 * @property int|null $expected_life_months
 * @property string|null $notes
 * @property int $workorder_id
 * @property int|null $part_id
 * @property int $performed_by
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
 * @property-read Collection<int, \App\Models\File> $files
 * @property-read int|null $files_count
 * @property-read \App\Models\Part|null $part
 * @property-read \App\Models\User|null $performedBy
 * @property-read Collection<int, \App\Models\WorkorderOperationLabourTime> $times
 * @property-read int|null $times_count
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\Workorder|null $workorder
 * @method static \Database\Factories\WorkorderOperationFactory factory($count = null, $state = [])
 * @method static Builder<static>|WorkorderOperation newModelQuery()
 * @method static Builder<static>|WorkorderOperation newQuery()
 * @method static Builder<static>|WorkorderOperation onlyTrashed()
 * @method static Builder<static>|WorkorderOperation query()
 * @method static Builder<static>|WorkorderOperation whereCreatedAt($value)
 * @method static Builder<static>|WorkorderOperation whereCreatedBy($value)
 * @method static Builder<static>|WorkorderOperation whereDeletedAt($value)
 * @method static Builder<static>|WorkorderOperation whereDeletedBy($value)
 * @method static Builder<static>|WorkorderOperation whereExpectedLifeKm($value)
 * @method static Builder<static>|WorkorderOperation whereExpectedLifeMonths($value)
 * @method static Builder<static>|WorkorderOperation whereId($value)
 * @method static Builder<static>|WorkorderOperation whereNotes($value)
 * @method static Builder<static>|WorkorderOperation wherePartId($value)
 * @method static Builder<static>|WorkorderOperation wherePartInstalledOdometer($value)
 * @method static Builder<static>|WorkorderOperation wherePerformedBy($value)
 * @method static Builder<static>|WorkorderOperation whereType($value)
 * @method static Builder<static>|WorkorderOperation whereUpdatedAt($value)
 * @method static Builder<static>|WorkorderOperation whereUpdatedBy($value)
 * @method static Builder<static>|WorkorderOperation whereWorkorderId($value)
 * @method static Builder<static>|WorkorderOperation withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|WorkorderOperation withoutTrashed()
 * @mixin \Eloquent
 */
#[Fillable([
    'type',
    'part_installed_odometer',
    'expected_life_km',
    'expected_life_months',
    'notes',
    'part_id',
    'performed_by',
])]
class WorkorderOperation extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $attributes = [
        'type' => WorkorderOperationType::REPAIR->value,
    ];

    public function isPartOfMyCompany(User $user): bool
    {
        return (bool) $this->workorder->booking->company->users()->find($user->id);
    }

    public function isPartOfMyWorkorder(User $user): bool
    {
        if ($user->hasAnyRole([UserRole::ADMINISTRATOR->value, UserRole::MANAGER->value])) {
            return $this->isPartOfMyCompany($user);
        }

        return (bool) $this->workorder->technician_id === $user->id;
    }

    public function isMine(User $user): bool
    {
        if ($user->hasAnyRole([UserRole::ADMINISTRATOR->value, UserRole::MANAGER->value])) {
            return $this->isPartOfMyCompany($user);
        }

        return (bool) $this->performed_by === $user->id;
    }

    public function hasActiveTime(): bool
    {
        $status = false;

        foreach ($this->times as $time) {
            if (!$time->end) {
                $status = true;
                break;
            }
        }

        return $status;
    }

    public function workorder(): BelongsTo
    {
        return $this->belongsTo(Workorder::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function times(): HasMany
    {
        return $this->hasMany(WorkorderOperationLabourTime::class, 'workorder_operation_id', 'id');
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }
    protected function casts(): array
    {
        return [
            'type' => WorkorderOperationType::class,
            'part_installed_odometer' => 'integer',
            'expected_life_km' => 'integer',
            'expected_life_months' => 'integer',
            'notes' => 'string',
        ];
    }
}

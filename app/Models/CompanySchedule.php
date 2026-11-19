<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\WeekDays;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property WeekDays $name
 * @property string|null $start
 * @property string|null $end
 * @property int $company_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\Company|null $company
 * @method static Builder<static>|CompanySchedule newModelQuery()
 * @method static Builder<static>|CompanySchedule newQuery()
 * @method static Builder<static>|CompanySchedule query()
 * @method static Builder<static>|CompanySchedule whereCompanyId($value)
 * @method static Builder<static>|CompanySchedule whereCreatedAt($value)
 * @method static Builder<static>|CompanySchedule whereEnd($value)
 * @method static Builder<static>|CompanySchedule whereId($value)
 * @method static Builder<static>|CompanySchedule whereName($value)
 * @method static Builder<static>|CompanySchedule whereStart($value)
 * @method static Builder<static>|CompanySchedule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'start',
    'end',
])]
class CompanySchedule extends Model
{
    use HasFactory;
    use LogsActivity;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    protected function casts(): array
    {
        return [
            'name' => WeekDays::class,
        ];
    }
}

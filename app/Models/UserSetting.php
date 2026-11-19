<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property int $user_id
 * @property int $default_company
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\Company|null $defaultCompany
 * @property-read \App\Models\User|null $user
 * @method static Builder<static>|UserSetting newModelQuery()
 * @method static Builder<static>|UserSetting newQuery()
 * @method static Builder<static>|UserSetting query()
 * @method static Builder<static>|UserSetting whereCreatedAt($value)
 * @method static Builder<static>|UserSetting whereDefaultCompany($value)
 * @method static Builder<static>|UserSetting whereId($value)
 * @method static Builder<static>|UserSetting whereUpdatedAt($value)
 * @method static Builder<static>|UserSetting whereUserId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'default_company',
])]
class UserSetting extends Model
{
    use LogsActivity;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function defaultCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'default_company');
    }
}

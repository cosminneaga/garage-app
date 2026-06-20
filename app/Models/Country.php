<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, Address> $address
 * @property-read int|null $address_count
 * @method static CountryFactory factory($count = null, $state = [])
 * @method static Builder<static>|Country newModelQuery()
 * @method static Builder<static>|Country newQuery()
 * @method static Builder<static>|Country onlyTrashed()
 * @method static Builder<static>|Country query()
 * @method static Builder<static>|Country whereCode($value)
 * @method static Builder<static>|Country whereCreatedAt($value)
 * @method static Builder<static>|Country whereDeletedAt($value)
 * @method static Builder<static>|Country whereId($value)
 * @method static Builder<static>|Country whereName($value)
 * @method static Builder<static>|Country whereUpdatedAt($value)
 * @method static Builder<static>|Country withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Country withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperCountry
 */
class Country extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [];

    public function address(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}

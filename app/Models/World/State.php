<?php

declare(strict_types=1);

namespace App\Models\World;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property string|null $country_code
 * @property-read Collection<int, City> $cities
 * @property-read int|null $cities_count
 * @property-read Country|null $country
 * @method static Builder<static>|State newModelQuery()
 * @method static Builder<static>|State newQuery()
 * @method static Builder<static>|State query()
 * @method static Builder<static>|State whereCountryCode($value)
 * @method static Builder<static>|State whereCountryId($value)
 * @method static Builder<static>|State whereId($value)
 * @method static Builder<static>|State whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperState
 */
#[Connection('world')]
class State extends Model
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'state_id');
    }
}

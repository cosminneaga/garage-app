<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $iso2
 * @property string $name
 * @property int $status
 * @property string $phone_code
 * @property string $iso3
 * @property string $region
 * @property string $subregion
 * @property-read Collection<int, City> $cities
 * @property-read int|null $cities_count
 * @property-read City|null $currency
 * @property-read Record|null $record
 * @property-read Collection<int, State> $states
 * @property-read int|null $states_count
 * @property-read Timezone|null $timezone
 * @method static Builder<static>|Country newModelQuery()
 * @method static Builder<static>|Country newQuery()
 * @method static Builder<static>|Country query()
 * @method static Builder<static>|Country whereId($value)
 * @method static Builder<static>|Country whereIso2($value)
 * @method static Builder<static>|Country whereIso3($value)
 * @method static Builder<static>|Country whereName($value)
 * @method static Builder<static>|Country wherePhoneCode($value)
 * @method static Builder<static>|Country whereRegion($value)
 * @method static Builder<static>|Country whereStatus($value)
 * @method static Builder<static>|Country whereSubregion($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCountry
 */
#[Connection('world')]
class Country extends Model
{
    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_id');
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'country_id');
    }

    public function currency(): HasOne
    {
        return $this->hasOne(City::class, 'country_id');
    }

    public function timezone(): HasOne
    {
        return $this->hasOne(Timezone::class, 'country_id');
    }

    public function record(): HasOne
    {
        return $this->hasOne(Record::class, foreignKey: 'record_id');
    }
}

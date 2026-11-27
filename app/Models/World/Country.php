<?php

namespace App\Models\World;

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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\World\City> $cities
 * @property-read int|null $cities_count
 * @property-read \App\Models\World\City|null $currency
 * @property-read \App\Models\World\Record|null $record
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\World\State> $states
 * @property-read int|null $states_count
 * @property-read \App\Models\World\Timezone|null $timezone
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereIso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereIso3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country wherePhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereSubregion($value)
 * @mixin \Eloquent
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

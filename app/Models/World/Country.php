<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
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

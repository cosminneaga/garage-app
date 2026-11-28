<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property-read Country|null $country
 * @method static Builder<static>|Timezone newModelQuery()
 * @method static Builder<static>|Timezone newQuery()
 * @method static Builder<static>|Timezone query()
 * @method static Builder<static>|Timezone whereCountryId($value)
 * @method static Builder<static>|Timezone whereId($value)
 * @method static Builder<static>|Timezone whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperTimezone
 */
#[Connection('world')]
class Timezone extends Model
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}

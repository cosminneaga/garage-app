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
 * @property string $code
 * @property int $precision
 * @property string $symbol
 * @property string $symbol_native
 * @property int $symbol_first
 * @property string $decimal_mark
 * @property string $thousands_separator
 * @property-read Country|null $country
 * @method static Builder<static>|Currency newModelQuery()
 * @method static Builder<static>|Currency newQuery()
 * @method static Builder<static>|Currency query()
 * @method static Builder<static>|Currency whereCode($value)
 * @method static Builder<static>|Currency whereCountryId($value)
 * @method static Builder<static>|Currency whereDecimalMark($value)
 * @method static Builder<static>|Currency whereId($value)
 * @method static Builder<static>|Currency whereName($value)
 * @method static Builder<static>|Currency wherePrecision($value)
 * @method static Builder<static>|Currency whereSymbol($value)
 * @method static Builder<static>|Currency whereSymbolFirst($value)
 * @method static Builder<static>|Currency whereSymbolNative($value)
 * @method static Builder<static>|Currency whereThousandsSeparator($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCurrency
 */
#[Connection('world')]
class Currency extends Model
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}

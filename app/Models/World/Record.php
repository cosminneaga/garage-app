<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $module
 * @property string $source_key
 * @property string $scope
 * @property int $record_id
 * @property string $attributes
 * @property-read \App\Models\World\Country|null $country
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereSourceKey($value)
 * @mixin \Eloquent
 */
#[Connection('world')]
#[Table(name: 'world_data_records')]
class Record extends Model
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, foreignKey: 'record_id');
    }
}

<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Builder;
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
 * @property-read Country|null $country
 * @method static Builder<static>|Record newModelQuery()
 * @method static Builder<static>|Record newQuery()
 * @method static Builder<static>|Record query()
 * @method static Builder<static>|Record whereAttributes($value)
 * @method static Builder<static>|Record whereId($value)
 * @method static Builder<static>|Record whereModule($value)
 * @method static Builder<static>|Record whereRecordId($value)
 * @method static Builder<static>|Record whereScope($value)
 * @method static Builder<static>|Record whereSourceKey($value)
 * @mixin \Eloquent
 * @mixin IdeHelperRecord
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

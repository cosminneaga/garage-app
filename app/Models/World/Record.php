<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
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

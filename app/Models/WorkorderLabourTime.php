<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @method static Builder<static>|WorkorderLabourTime newModelQuery()
 * @method static Builder<static>|WorkorderLabourTime newQuery()
 * @method static Builder<static>|WorkorderLabourTime onlyTrashed()
 * @method static Builder<static>|WorkorderLabourTime query()
 * @method static Builder<static>|WorkorderLabourTime withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|WorkorderLabourTime withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperWorkorderLabourTime
 */
class WorkorderLabourTime extends Model
{
    use Blameable;
    use SoftDeletes;
}

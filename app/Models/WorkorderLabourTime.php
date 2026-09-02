<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Blameable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

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
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function (WorkorderLabourTime $time) {
            $time->start ??= Carbon::now();
        });
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(WorkorderOperation::class);
    }
}

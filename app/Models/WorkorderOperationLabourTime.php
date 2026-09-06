<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\WorkorderOperationLabourTimeObserver;
use App\Traits\Blameable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @mixin IdeHelperWorkorderOperationLabourTime
 */
#[ObservedBy(WorkorderOperationLabourTimeObserver::class)]
class WorkorderOperationLabourTime extends Model
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
        static::creating(function (WorkorderOperationLabourTime $time) {
            $time->start ??= Carbon::now();
        });
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(WorkorderOperation::class, 'workorder_operation_id', 'id');
    }
}

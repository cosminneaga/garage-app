<?php

namespace App\Models;

use App\Enums\Status\WorkorderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class WorkorderStatusHistory extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'status',
        'description'
    ];

    protected $attributes = [
        'status' => WorkorderStatus::class
    ];

    public function workorder(): BelongsTo
    {
        return $this->belongsTo(Workorder::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Override;
use App\Enums\Status\WorkorderStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property WorkorderStatus $status
 * @property string|null $description
 * @property int $workorder_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Workorder|null $workorder
 * @method static Builder<static>|WorkorderStatusHistory newModelQuery()
 * @method static Builder<static>|WorkorderStatusHistory newQuery()
 * @method static Builder<static>|WorkorderStatusHistory query()
 * @method static Builder<static>|WorkorderStatusHistory whereCreatedAt($value)
 * @method static Builder<static>|WorkorderStatusHistory whereDescription($value)
 * @method static Builder<static>|WorkorderStatusHistory whereId($value)
 * @method static Builder<static>|WorkorderStatusHistory whereStatus($value)
 * @method static Builder<static>|WorkorderStatusHistory whereUpdatedAt($value)
 * @method static Builder<static>|WorkorderStatusHistory whereWorkorderId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperWorkorderStatusHistory
 */
#[Fillable([
    'status',
    'description',
])]
class WorkorderStatusHistory extends Model
{
    #[Override]
    protected $attributes = [
        'status' => WorkorderStatus::PENDING->value,
    ];

    protected function casts()
    {
        return [
            'status' => WorkorderStatus::class,
        ];
    }

    public function workorder(): BelongsTo
    {
        return $this->belongsTo(Workorder::class);
    }
}

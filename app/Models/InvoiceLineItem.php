<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Type\WorkorderOperationType;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @mixin IdeHelperInvoiceLineItem
 */
#[Fillable(
    'type',
    'worked_minutes',
    'total_cost',
    'part_id',
    'invoice_item_id',
)]
class InvoiceLineItem extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Blameable;

    protected $attributes = [
        'type' => WorkorderOperationType::OTHER->value,
        'worked_minutes' => 0,
        'total_cost' => 0.00,
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'type' => WorkorderOperationType::class,
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(InvoiceItem::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}

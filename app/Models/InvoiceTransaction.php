<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\Type\TransactionType;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property PaymentMethod $method
 * @property TransactionType $type
 * @property numeric $value
 * @property int $invoice_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Model|\Eloquent|null $createdByActor
 * @property-read \App\Models\User|null $creator
 * @property-read Model|\Eloquent|null $deletedByActor
 * @property-read \App\Models\User|null $deletor
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read Model|\Eloquent|null $updatedByActor
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceTransaction withoutTrashed()
 * @mixin \Eloquent
 */
#[Fillable([
    'method',
    'type',
    'value',
    'invoice_id',
])]
class InvoiceTransaction extends Model
{
    use LogsActivity;
    use SoftDeletes;
    use Blameable;
    use Searchable;

    protected $attributes = [
        'method' => PaymentMethod::OTHER->value,
        'type' => TransactionType::PAYMENT->value,
        'value' => 0.00,
    ];

    protected function casts(): array
    {
        return [
            'method' => PaymentMethod::class,
            'type' => TransactionType::class,
            'value' => 'decimal:2',
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'method' => $this->method,
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}

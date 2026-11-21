<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
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
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Model|\Eloquent|null $createdByActor
 * @property-read User|null $creator
 * @property-read Model|\Eloquent|null $deletedByActor
 * @property-read User|null $deletor
 * @property-read Invoice|null $invoice
 * @property-read Model|\Eloquent|null $updatedByActor
 * @property-read User|null $updater
 * @method static Builder<static>|InvoiceTransaction newModelQuery()
 * @method static Builder<static>|InvoiceTransaction newQuery()
 * @method static Builder<static>|InvoiceTransaction onlyTrashed()
 * @method static Builder<static>|InvoiceTransaction query()
 * @method static Builder<static>|InvoiceTransaction whereCreatedAt($value)
 * @method static Builder<static>|InvoiceTransaction whereCreatedBy($value)
 * @method static Builder<static>|InvoiceTransaction whereDeletedAt($value)
 * @method static Builder<static>|InvoiceTransaction whereDeletedBy($value)
 * @method static Builder<static>|InvoiceTransaction whereId($value)
 * @method static Builder<static>|InvoiceTransaction whereInvoiceId($value)
 * @method static Builder<static>|InvoiceTransaction whereMethod($value)
 * @method static Builder<static>|InvoiceTransaction whereType($value)
 * @method static Builder<static>|InvoiceTransaction whereUpdatedAt($value)
 * @method static Builder<static>|InvoiceTransaction whereUpdatedBy($value)
 * @method static Builder<static>|InvoiceTransaction whereValue($value)
 * @method static Builder<static>|InvoiceTransaction withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|InvoiceTransaction withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperInvoiceTransaction
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

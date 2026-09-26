<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Database\Factories\PartFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property string|null $manufacturer
 * @property string|null $part_number
 * @property string|null $serial_number
 * @property string|null $code
 * @property string|null $notes
 * @property float $item_price
 * @property float $commercial_markup
 * @property int $brand
 * @property int $supplier_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $deletor
 * @property-read Collection<int, \App\Models\WorkorderOperation> $operations
 * @property-read int|null $operations_count
 * @property-read \App\Models\Supplier|null $supplier
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\PartFactory factory($count = null, $state = [])
 * @method static Builder<static>|Part newModelQuery()
 * @method static Builder<static>|Part newQuery()
 * @method static Builder<static>|Part onlyTrashed()
 * @method static Builder<static>|Part query()
 * @method static Builder<static>|Part whereBrand($value)
 * @method static Builder<static>|Part whereCode($value)
 * @method static Builder<static>|Part whereCommercialMarkup($value)
 * @method static Builder<static>|Part whereCreatedAt($value)
 * @method static Builder<static>|Part whereCreatedBy($value)
 * @method static Builder<static>|Part whereDeletedAt($value)
 * @method static Builder<static>|Part whereDeletedBy($value)
 * @method static Builder<static>|Part whereId($value)
 * @method static Builder<static>|Part whereItemPrice($value)
 * @method static Builder<static>|Part whereManufacturer($value)
 * @method static Builder<static>|Part whereName($value)
 * @method static Builder<static>|Part whereNotes($value)
 * @method static Builder<static>|Part wherePartNumber($value)
 * @method static Builder<static>|Part whereSerialNumber($value)
 * @method static Builder<static>|Part whereSupplierId($value)
 * @method static Builder<static>|Part whereUpdatedAt($value)
 * @method static Builder<static>|Part whereUpdatedBy($value)
 * @method static Builder<static>|Part withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Part withoutTrashed()
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'manufacturer',
    'part_number',
    'serial_number',
    'code',
    'notes',
    'item_price',
    'commercial_markup',
])]
class Part extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $attributes = [
        'item_price' => 0.00,
        'commercial_markup' => 0.00,
    ];

    public function operations(): HasMany
    {
        return $this->hasMany(WorkorderOperation::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
    protected function casts(): array
    {
        return [
            'item_price' => 'float',
            'commercial_markup' => 'float',
        ];
    }
}

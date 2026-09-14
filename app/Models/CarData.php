<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @mixin IdeHelperCarData
 */
class CarData extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'cylinders',
        'displacement',
        'drive',
        'transmission',
    ];

    protected $casts = [
        'displacement' => 'float',
    ];

    public function make(): BelongsTo
    {
        return $this->belongsTo(CarMake::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }
}

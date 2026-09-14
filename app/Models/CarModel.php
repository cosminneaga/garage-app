<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @mixin IdeHelperCarModel
 */
class CarModel extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [];

    public function make(): BelongsTo
    {
        return $this->belongsTo(CarMake::class);
    }
}

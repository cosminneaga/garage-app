<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\WeekDays;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @mixin IdeHelperCompanySchedule
 */
class CompanySchedule extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'start',
        'end',
    ];

    protected $casts = [
        'name' => WeekDays::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @mixin IdeHelperBookingStatusHistory
 */
class BookingStatusHistory extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'status',
        'description',
    ];

    protected $attributes = [
        'status' => BookingStatus::class,
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}

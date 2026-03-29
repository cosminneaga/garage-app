<?php

declare(strict_types=1);

namespace App\Models;

// use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'notes',
        'on',
    ];

    protected $casts = [
        'on' => 'datetime',
    ];

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }
}

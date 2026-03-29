<?php

namespace App\Models;

// use Database\Factories\RepairFactory;
use App\Enums\FuelType;
use App\Enums\RepairStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repair extends Model
{
    /** @use HasFactory<RepairFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    protected $casts = [
        'status' => RepairStatus::class,
        'fuel' => FuelType::class,
    ];

    protected $attributes = [
        'status' => RepairStatus::RECEPTION->value,
        'fuel' => FuelType::OTHER->value,
    ];

    public function files(): HasMany
    {
        return $this->hasMany(RepairFile::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(RepairInvoice::class);
    }

    public function data(): BelongsTo
    {
        return $this->belongsTo(VehicleData::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}

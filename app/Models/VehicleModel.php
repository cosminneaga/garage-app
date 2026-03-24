<?php

namespace App\Models;

// use Database\Factories\VehicleModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleModel extends Model
{
    /** @use HasFactory<VehicleModelFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    public function make(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(VehicleYear::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(VehicleData::class);
    }
}

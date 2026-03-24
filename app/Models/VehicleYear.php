<?php

namespace App\Models;

// use Database\Factories\VehicleYearFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleYear extends Model
{
    /** @use HasFactory<VehicleYearFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(VehicleData::class);
    }
}

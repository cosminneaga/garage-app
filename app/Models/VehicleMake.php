<?php

namespace App\Models;

// use Database\Factories\VehicleMakeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleMake extends Model
{
    /** @use HasFactory<VehicleMakeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function models(): HasMany
    {
        return $this->hasMany(VehicleModel::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(VehicleData::class);
    }
}

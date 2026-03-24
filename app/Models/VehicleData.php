<?php

namespace App\Models;

// use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleData extends Model
{
    /** @use HasFactory<VehicleFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'cylinders',
        'displacement',
        'drive',
        'transmission',
    ];

    public function make(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(VehicleYear::class);
    }
}

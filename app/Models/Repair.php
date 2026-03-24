<?php

namespace App\Models;

// use Database\Factories\RepairFactory;
use App\FuelType;
use App\RepairStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}

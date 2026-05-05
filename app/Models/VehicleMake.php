<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class VehicleMake extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
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

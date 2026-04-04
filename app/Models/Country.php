<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Country extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [];

    public function address(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}

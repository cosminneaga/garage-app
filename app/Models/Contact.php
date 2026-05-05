<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Contact extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'mobile',
        'landline',
        'email',
        'info',
        'url',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class);
    }
}

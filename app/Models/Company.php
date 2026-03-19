<?php

namespace App\Models;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory;

    // public function users(): HasMany
    // {
    //     return $this->hasMany(User::class);
    // }
    public function users(): BelongsToMany
    {
        // return $this->belongsToMany(User::class);
        return $this->belongsToMany(
            User::class,
            'companies_users',
            'company_id',
            'user_id'
        );
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    /** @use HasFactory<PersonalInfoFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'street',
        'postcode',
        'extra',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsTo(Company::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsTo(Client::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'street',
        'number',
        'address_extrainfo',
        'postcode',
        'mobile',
        'landline',
    ];

    protected $hidden = [
        'password',
    ];

    protected $attributes = [
        'active' => false,
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Address extends Model
{
    /** @use HasFactory<PersonalInfoFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'number',
        'street',
        'postcode',
        'extra',
        'country_id',
    ];

    public function setCoordinates(): Attribute
    {
        return Attribute::make(
            set: fn ($longitude, $latitude) => DB::raw("ST_PointFromText('POINT($longitude $latitude)')")
        );
    }

    public function coordinatesAsText(): Attribute
    {
        return Attribute::make(
            get: fn () => DB::raw("ST_AsText($this->coordinates)")
        );
    }

    public function coordinatesAsBinary(): Attribute
    {
        return Attribute::make(
            get: fn () => DB::raw("ST_AsBinary($this->coordinates)")
        );
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}

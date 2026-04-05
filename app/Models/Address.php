<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
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

    /**
     * $address = Address::query()->create([
     *  'coordinates' => [
     *  'longitude' => 4.895168,
     *  'latitude' => 52.370216,
     * ]
     * ]);
     *
     * $address->coordinates;
     */
    public function coordinates(): Attribute
    {

        return Attribute::make(
            get: fn () => [
                'latitude' => $this->query()->whereKey($this)->selectRaw('ST_Y(`coordinates`) as latitude')->toBase()->soleValue('latitude'),
                'longitude' => $this->query()->whereKey($this)->selectRaw('ST_X(`coordinates`) as longitude')->toBase()->soleValue('longitude'),
            ],
            set: fn ($value) => DB::raw("ST_GeomFromText('POINT({$value['longitude']} {$value['latitude']})', 4326)")
        );
    }

    #[Scope]
    protected function withCoordinatesText($query)
    {
        return $query->selectRaw('*, ST_AsText(coordinates) as coordinates_text');
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

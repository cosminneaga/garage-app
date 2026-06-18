<?php

declare(strict_types=1);

namespace App\Models;

use App\Dto\Coordinates;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $number
 * @property string $street
 * @property string $postcode
 * @property \App\Dto\Coordinates|null $coordinates
 * @property string|null $extra
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @property-read Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \App\Models\Country|null $country
 * @property-read Collection<int, \App\Models\Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\AddressFactory factory($count = null, $state = [])
 * @method static Builder<static>|Address newModelQuery()
 * @method static Builder<static>|Address newQuery()
 * @method static Builder<static>|Address onlyTrashed()
 * @method static Builder<static>|Address query()
 * @method static Builder<static>|Address whereCoordinates($value)
 * @method static Builder<static>|Address whereCountryId($value)
 * @method static Builder<static>|Address whereCreatedAt($value)
 * @method static Builder<static>|Address whereDeletedAt($value)
 * @method static Builder<static>|Address whereExtra($value)
 * @method static Builder<static>|Address whereId($value)
 * @method static Builder<static>|Address whereNumber($value)
 * @method static Builder<static>|Address wherePostcode($value)
 * @method static Builder<static>|Address whereStreet($value)
 * @method static Builder<static>|Address whereUpdatedAt($value)
 * @method static Builder<static>|Address withCoordinates()
 * @method static Builder<static>|Address withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Address withoutTrashed()
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'number',
        'street',
        'postcode',
        'extra',
        'country_id',
        'coordinates',
        'coordinates->latitude',
        'coordinates->longitude',
    ];

    protected $attributes = [
        'coordinates' => null,
    ];

    /**
     * $address = Address::query()->create([
     *  'coordinates' => [
     *      'longitude' => 4.895168,
     *      'latitude' => 52.370216,
     * ]
     * ]);
     *
     * $address->coordinates->longitude;
     * $address->coordinates->latitude;
     */
    public function coordinates(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes): Coordinates|null {
                if (!$attributes['coordinates']) {
                    return null;
                }

                $result = $this
                    ->whereKey($this->getKey())
                    ->selectRaw('ST_Y(coordinates) as latitude, ST_X(coordinates) as longitude')
                    ->first();

                return new Coordinates(
                    latitude: (float) $result->latitude,
                    longitude: (float) $result->longitude
                );
            },
            set: function (mixed $value): Expression|null {

                $value = Coordinates::format($value);
                if ($value instanceof \App\Dto\Coordinates) {
                    return DB::raw("ST_GeomFromText('POINT({$value->longitude} {$value->latitude})', 4326)");
                }

                return null;
            },
        );
    }

    #[Scope]
    protected function withCoordinates(Builder $query): Builder
    {
        return $query->select('*')->addSelect([
            'latitude' => DB::raw('ST_Y(coordinates) as latitude'),
            'longitude' => DB::raw('ST_X(coordinates) as longitude'),
        ]);
    }

    public static function updateOrCreateByCoordinates(
        string|float $latitude,
        string|float $longitude,
        array $attributes
    ): Address {
        $instance = self::query()
            ->whereRaw('ST_Y(coordinates) = ?', [$latitude], 'and')
            ->whereRaw('ST_X(coordinates) = ?', [$longitude], 'and')
            ->first();

        if ($instance) {
            $instance->update($attributes);
        } else {
            $instance = self::create([
                ...$attributes,
                'coordinates' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ],
            ]);
        }

        return $instance;
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

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $type
 * @property int|null $part_installed_odometer
 * @property int|null $expected_life_km
 * @property int|null $expected_life_months
 * @property string|null $notes
 * @property int $workorder_id
 * @property int|null $part_id
 * @property int $performed_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @method static Builder<static>|WorkorderOperation newModelQuery()
 * @method static Builder<static>|WorkorderOperation newQuery()
 * @method static Builder<static>|WorkorderOperation onlyTrashed()
 * @method static Builder<static>|WorkorderOperation query()
 * @method static Builder<static>|WorkorderOperation whereCreatedAt($value)
 * @method static Builder<static>|WorkorderOperation whereCreatedBy($value)
 * @method static Builder<static>|WorkorderOperation whereDeletedAt($value)
 * @method static Builder<static>|WorkorderOperation whereExpectedLifeKm($value)
 * @method static Builder<static>|WorkorderOperation whereExpectedLifeMonths($value)
 * @method static Builder<static>|WorkorderOperation whereId($value)
 * @method static Builder<static>|WorkorderOperation whereNotes($value)
 * @method static Builder<static>|WorkorderOperation wherePartId($value)
 * @method static Builder<static>|WorkorderOperation wherePartInstalledOdometer($value)
 * @method static Builder<static>|WorkorderOperation wherePerformedBy($value)
 * @method static Builder<static>|WorkorderOperation whereType($value)
 * @method static Builder<static>|WorkorderOperation whereUpdatedAt($value)
 * @method static Builder<static>|WorkorderOperation whereUpdatedBy($value)
 * @method static Builder<static>|WorkorderOperation whereWorkorderId($value)
 * @method static Builder<static>|WorkorderOperation withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|WorkorderOperation withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperWorkorderOperation
 */
class WorkorderOperation extends Model
{
    use SoftDeletes;
    use Blameable;
}

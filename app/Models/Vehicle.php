<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperVehicle
 */
class Vehicle extends Model
{
    use SoftDeletes;
    use Blameable;
}

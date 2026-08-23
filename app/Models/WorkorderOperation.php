<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperWorkorderOperation
 */
class WorkorderOperation extends Model
{
    use SoftDeletes;
    use Blameable;
}

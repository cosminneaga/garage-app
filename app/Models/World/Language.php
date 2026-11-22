<?php

declare(strict_types=1);

namespace App\Models\World;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLanguage
 */
#[Connection('world')]
class Language extends Model
{
}

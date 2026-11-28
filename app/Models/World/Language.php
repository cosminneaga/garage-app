<?php

declare(strict_types=1);

namespace App\Models\World;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_native
 * @property string $dir
 * @method static Builder<static>|Language newModelQuery()
 * @method static Builder<static>|Language newQuery()
 * @method static Builder<static>|Language query()
 * @method static Builder<static>|Language whereCode($value)
 * @method static Builder<static>|Language whereDir($value)
 * @method static Builder<static>|Language whereId($value)
 * @method static Builder<static>|Language whereName($value)
 * @method static Builder<static>|Language whereNameNative($value)
 * @mixin \Eloquent
 * @mixin IdeHelperLanguage
 */
#[Connection('world')]
class Language extends Model
{
}

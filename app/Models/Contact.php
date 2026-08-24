<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $mobile
 * @property string|null $landline
 * @property string|null $email
 * @property string|null $url
 * @property string|null $info
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, User> $clients
 * @property-read int|null $clients_count
 * @property-read Collection<int, Company> $companies
 * @property-read int|null $companies_count
 * @property-read Collection<int, Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static ContactFactory factory($count = null, $state = [])
 * @method static Builder<static>|Contact newModelQuery()
 * @method static Builder<static>|Contact newQuery()
 * @method static Builder<static>|Contact onlyTrashed()
 * @method static Builder<static>|Contact query()
 * @method static Builder<static>|Contact whereCreatedAt($value)
 * @method static Builder<static>|Contact whereCreatedBy($value)
 * @method static Builder<static>|Contact whereDeletedAt($value)
 * @method static Builder<static>|Contact whereEmail($value)
 * @method static Builder<static>|Contact whereId($value)
 * @method static Builder<static>|Contact whereInfo($value)
 * @method static Builder<static>|Contact whereLandline($value)
 * @method static Builder<static>|Contact whereMobile($value)
 * @method static Builder<static>|Contact whereUpdatedAt($value)
 * @method static Builder<static>|Contact whereUpdatedBy($value)
 * @method static Builder<static>|Contact whereUrl($value)
 * @method static Builder<static>|Contact withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Contact withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperContact
 */
class Contact extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'mobile',
        'landline',
        'email',
        'info',
        'url',
    ];

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
        return $this->belongsToMany(User::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class);
    }
}

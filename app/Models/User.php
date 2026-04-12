<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Traits\HasRoles;

#[UsePolicy(UserPolicy::class)]
class User extends Authenticatable
{
    use HasFactory, HasRoles, LogsActivity, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'image_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'active' => false,
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isTeamMember(User $user): bool
    {
        if ($this->hasRole(UserRole::USER_EDITOR)) {
            $manager = $this->managers()->first();

            return (bool) $manager->members()->findOrFail($user->id);
        }

        return (bool) $this->members()->withTrashed()->findOrFail($user->id);
    }

    public function chart(): array
    {
        $data = $this->select('created_at as date', DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'date' => collect($data)->pluck('date')->toArray(),
            'count' => collect($data)->pluck('count')->toArray(),
        ];
    }

    #[Scope]
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            Team::class,
            'manager_id',
            'user_id'
        );
    }

    #[Scope]
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            Team::class,
            'user_id',
            'manager_id'
        );
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }

    public function team(): BelongsToMany
    {
        if (! $this->getRoleNames()
            ->contains(fn ($item) => in_array($item, [
                UserRole::SUPER->value,
                UserRole::USER_ADMIN->value,
            ]
            ))) {
            throw new UnauthorizedException(403)->forRoles([UserRole::SUPER->value, UserRole::USER_ADMIN->value]);
        }

        return $this->belongsToMany(
            User::class,
            Team::class,
            'manager_id',
            'user_id'
        )->withTimestamps();
    }
}

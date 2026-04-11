<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Policies\CompanyPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

#[UsePolicy(CompanyPolicy::class)]
class Company extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'tax_id',
        'tax_value',
        'invoice_prefix',
        'registration_number',
    ];

    protected $casts = [
        'tax_value' => 'float',
    ];

    public function isCompanyImPartOf(User $user): bool
    {
        if ($user->hasRole(UserRole::USER_EDITOR)) {
            $manager = $user->managers()->first();

            return (bool) $this->users()->findOrFail($manager->id);
        }

        return (bool) $this->users()->findOrFail($user->id);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class);
    }
}

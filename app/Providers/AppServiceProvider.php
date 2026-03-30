<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Model::unguard();
        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();
        Gate::before(fn ($user, $ability) => $user->hasRole(UserRole::ADMIN_SUPER->value) ? true : null);
    }
}

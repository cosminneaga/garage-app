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
        // dd($this->app);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(fn ($user, $ability) => $user->hasRole(UserRole::SUPER->value) ? true : null);
        // Gate::before(function ($user, $ability) {
        //     return $user->hasPermissionTo($ability) ? true : null;
        // });
        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();
    }
}

<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
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
        Blade::anonymousComponentPath(
            resource_path('views/layout'),
            'layout'
        );

        Blade::directive('datetime', function (string $expression) {
            return "<?php echo ($expression)->format('d/m/Y H:i'); ?>";
        });

        Gate::before(fn ($user, $ability) => $user->hasRole(UserRole::SUPER->value) ? true : null);
        Gate::before(function ($user) {
            if (! $user->active) {
                return false;
            }
        });
        Gate::define('viewPulse', function (User $user): bool {
            if (app()->environment('local')) {
                return true;
            }

            return $user->hasRole(UserRole::SUPER->value);
        });

        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();
    }
}

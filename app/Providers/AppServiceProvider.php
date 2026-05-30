<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        class_alias(Permission::class, 'Permission');

        Blade::anonymousComponentPath(
            resource_path('views/layout'),
            'layout',
        );
        Blade::anonymousComponentPath(
            resource_path('views/navigation'),
            'navigation',
        );

        Blade::directive('datetime', fn (string $expression) => "<?php echo ($expression)->format('d/m/Y H:i'); ?>");
        Blade::directive('enctype', fn () => config('app.env') === 'testing' ? 'application/x-www-form-urlencoded' : 'multipart/form-data');

        Blade::if('testing', fn () => config('app.env') === 'testing');
        Blade::if('notTesting', fn () => config('app.env') !== 'testing');
        Blade::if('isCurrentUser', fn ($id) => Auth::user()->id === $id);
        Blade::if('isNotCurrentUser', fn ($id) => Auth::check() && Auth::user()->id !== $id);
        Blade::if('permitted', fn (UserPermission $permission, string $action) => Auth::user()->can(UserPermission::name($permission, $action)));

        Blade::if('super', fn () => Auth::check() && Auth::user()->hasRole(UserRole::SUPER->value));
        Blade::if('admin', fn () => Auth::check() && Auth::user()->hasRole(UserRole::USER_ADMIN->value));
        Blade::if('editor', fn () => Auth::check() && Auth::user()->hasRole(UserRole::USER_EDITOR->value));
        Blade::if('viewer', fn () => Auth::check() && Auth::user()->hasRole(UserRole::USER_VIEWER->value));

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

<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\Columns\AddressColumns;
use App\Enums\Columns\CompanyColumns;
use App\Enums\Columns\ContactColumns;
use App\Enums\Columns\SupplierColumns;
use App\Enums\Columns\UserColumns;
use App\Enums\SupplierType;
use App\Enums\Tabs\CompanyTabs;
use App\Enums\Tabs\SupplierTabs;
use App\Enums\Tabs\UserProfileTabs;
use App\Enums\Tabs\UserTabs;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('Permission', Permission::class);
        $loader->alias('UserPermission', UserPermission::class);
        $loader->alias('UserRole', UserRole::class);
        $loader->alias('SupplierType', SupplierType::class);
        $loader->alias('UserTabs', UserTabs::class);
        $loader->alias('CompanyTabs', CompanyTabs::class);
        $loader->alias('SupplierTabs', SupplierTabs::class);
        $loader->alias('CompanyColumns', CompanyColumns::class);
        $loader->alias('SupplierColumns', SupplierColumns::class);
        $loader->alias('UserColumns', UserColumns::class);
        $loader->alias('AddressColumns', AddressColumns::class);
        $loader->alias('ContactColumns', ContactColumns::class);
        $loader->alias('Country', Country::class);
        $loader->alias('UserProfileTabs', UserProfileTabs::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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

        Blade::if('super', fn () => Auth::check() && Auth::user()->hasRole(UserRole::SUPER));
        Blade::if('administrator', fn () => Auth::check() && Auth::user()->hasRole(UserRole::ADMINISTRATOR));
        Blade::if('manager', fn () => Auth::check() && Auth::user()->hasRole(UserRole::MANAGER));
        Blade::if('user', fn () => Auth::check() && Auth::user()->hasRole(UserRole::USER));
        Blade::if('permitted', fn (UserPermission $permission, string $action) => Auth::check() && Auth::user()->can(UserPermission::name($permission, $action)));

        Gate::before(function ($user): ?bool {
            if (! $user->active) {
                return false;
            }

            if ($user->hasRole(UserRole::SUPER)) {
                return true;
            }
            return null;
        });
        Gate::define('viewPulse', function (User $user): bool {
            if (app()->environment('local')) {
                return true;
            }

            return $user->hasRole(UserRole::SUPER);
        });

        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();

        Collection::macro('getBy', fn (string $key, mixed $value) => $this->firstWhere($key, $value));
        Collection::macro('existsInList', fn (array $list, array $compareList) => (bool) $this->values()->every(fn ($value) => in_array($value, $compareList)));
        Str::macro('generateFormFieldName', function (string $name, $nested_parent): string {
            if (!$nested_parent) {
                return $name;
            }

            // Convert "a[b][c]" => ["a", "b", "c"]
            $toSegments = function (string $value): array {
                $value = str_replace(['[', ']'], ['[', ''], $value);
                return array_values(array_filter(explode('[', $value)));
            };

            $parentSegments = $toSegments($nested_parent);
            $nameSegments   = $toSegments($name);

            // Merge paths
            $segments = array_merge($parentSegments, $nameSegments);

            // Rebuild into bracket notation
            $root = array_shift($segments);
            return $root . array_reduce($segments, fn ($carry, $segment) => $carry . '[' . $segment . ']', '');
        });
    }
}

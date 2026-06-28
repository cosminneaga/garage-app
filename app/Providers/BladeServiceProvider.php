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
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('AddressColumns', AddressColumns::class);
        $loader->alias('CompanyColumns', CompanyColumns::class);
        $loader->alias('CompanyTabs', CompanyTabs::class);
        $loader->alias('ContactColumns', ContactColumns::class);
        $loader->alias('Country', Country::class);
        $loader->alias('Permission', Permission::class);
        $loader->alias('SupplierColumns', SupplierColumns::class);
        $loader->alias('SupplierTabs', SupplierTabs::class);
        $loader->alias('SupplierType', SupplierType::class);
        $loader->alias('UserColumns', UserColumns::class);
        $loader->alias('UserPermission', UserPermission::class);
        $loader->alias('UserProfileTabs', UserProfileTabs::class);
        $loader->alias('UserRole', UserRole::class);
        $loader->alias('UserTabs', UserTabs::class);
    }

    /**
     * Bootstrap services.
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
    }
}

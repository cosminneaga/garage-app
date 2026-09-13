<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\Status\BookingStatus;
use App\Enums\Columns\ActionColumn;
use App\Enums\Columns\AddressColumns;
use App\Enums\Columns\BookingColumns;
use App\Enums\Columns\ClientColumns;
use App\Enums\Columns\CompanyColumns;
use App\Enums\Columns\ContactColumns;
use App\Enums\Columns\PermissionColumns;
use App\Enums\Columns\SupplierColumns;
use App\Enums\Columns\UserColumns;
use App\Enums\Columns\VehicleColumns;
use App\Enums\Type\FuelType;
use App\Enums\Priority;
use App\Enums\Related\RelatedModel;
use App\Enums\Type\ServiceType;
use App\Enums\Type\SupplierType;
use App\Enums\Tabs\CompanyTabs;
use App\Enums\Tabs\NotificationTabs;
use App\Enums\Tabs\SupplierTabs;
use App\Enums\Tabs\UserProfileTabs;
use App\Enums\Tabs\UserTabs;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Enums\Status\VehicleStatus;
use App\Helpers\BladeFormHelper;
use App\Helpers\Permission;
use App\Models\Country;
use App\Models\VehicleData;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleYear;
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
        $loader->alias('NotificationTabs', NotificationTabs::class);
        $loader->alias('Permission', Permission::class);
        $loader->alias('PermissionColumns', PermissionColumns::class);
        $loader->alias('SupplierColumns', SupplierColumns::class);
        $loader->alias('SupplierTabs', SupplierTabs::class);
        $loader->alias('SupplierType', SupplierType::class);
        $loader->alias('UserColumns', UserColumns::class);
        $loader->alias('UserPermission', UserPermission::class);
        $loader->alias('UserProfileTabs', UserProfileTabs::class);
        $loader->alias('UserRole', UserRole::class);
        $loader->alias('UserTabs', UserTabs::class);
        $loader->alias('RelatedModel', RelatedModel::class);

        $loader->alias('BookingStatus', BookingStatus::class);
        $loader->alias('ServiceType', ServiceType::class);
        $loader->alias('Priority', Priority::class);
        $loader->alias('FuelType', FuelType::class);
        $loader->alias('VehicleStatus', VehicleStatus::class);
        $loader->alias('BookingColumns', BookingColumns::class);
        $loader->alias('ActionColumn', ActionColumn::class);
        $loader->alias('VehicleColumns', VehicleColumns::class);
        $loader->alias('ClientColumns', ClientColumns::class);


        $loader->alias('VehicleMake', VehicleMake::class);
        $loader->alias('VehicleModel', VehicleModel::class);
        $loader->alias('VehicleData', VehicleData::class);
        $loader->alias('VehicleYear', VehicleYear::class);

        $loader->alias('BladeFormHelper', BladeFormHelper::class);
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

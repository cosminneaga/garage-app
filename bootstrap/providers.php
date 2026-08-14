<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\BladeServiceProvider;
use App\Providers\BlueprintServiceProvider;
use App\Providers\ExtensionServiceProvider;
use App\Providers\TelescopeServiceProvider;

return [
    AppServiceProvider::class,
    BladeServiceProvider::class,
    ExtensionServiceProvider::class,
    TelescopeServiceProvider::class,
    BlueprintServiceProvider::class,
];

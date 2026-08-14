<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class BlueprintServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blueprint::macro('auditColumns', function () {
            $this->timestamps();
            $this->softDeletes();
            $this->foreignIdFor(User::class, 'created_by')->nullable()->constrained();
            $this->foreignIdFor(User::class, 'updated_by')->nullable()->constrained();
        });
    }
}

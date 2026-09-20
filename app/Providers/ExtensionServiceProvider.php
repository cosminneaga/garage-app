<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ExtensionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

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

        Carbon::macro('generateTimeSlots', function (string $start, string $end, int $interval = 30): array {
            $slots = [];

            $current = Carbon::createFromFormat('H:i', $start);
            $finish = Carbon::createFromFormat('H:i', $end);

            while ($current->lt($finish)) {
                $slots[] = $current->format('H:i');
                $current->addMinutes($interval);
            }

            return $slots;
        });

        Blueprint::macro('auditColumns', function () {
            $this->foreignIdFor(User::class, 'created_by')->nullable()->constrained();
            $this->foreignIdFor(User::class, 'updated_by')->nullable()->constrained();
            $this->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained();
            $this->softDeletes();
            $this->timestamps();
        });
    }
}

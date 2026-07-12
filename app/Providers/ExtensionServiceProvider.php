<?php

declare(strict_types=1);

namespace App\Providers;

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

        Collection::macro('getBy', function (string $key, mixed $value) {
            return $this->firstWhere($key, $value);
        });
        Collection::macro('existsInList', function (array $list, array $compareList) {
            return (bool) $this->values()->every(fn($value) => in_array($value, $compareList));
        });
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

<?php

declare(strict_types=1);

namespace Tests;

use Database\Seeders\TestPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;

use function Pest\Laravel\seed;

abstract class MySqlTestCase extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        seed(TestPermissionsSeeder::class);
    }

    public function createApplication()
    {
        $app = parent::createApplication();
        $app['config']->set('database.default', 'mysql_testing');

        $app['config']->set('database.connections.mysql_testing', [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3406',
            'database' => 'testing',
            'username' => 'root',
            'password' => 'toor',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
        ]);

        $app['config']->set('cache.default', 'array');
        $app['config']->set('app.env', 'testing');

        return $app;
    }
}

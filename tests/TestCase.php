<?php namespace SlonCorp\Acl\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Laravel Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \SlonCorp\Acl\AclServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     */
    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        // Laravel App Configs
        $config->set('database.default', 'testing');
        $config->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $config->set('auth.model', \SlonCorp\Acl\Models\Eloquent\User::class);
        $config->set('auth.providers.users.model', \SlonCorp\Acl\Models\Eloquent\User::class);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get table names.
     *
     * @return array
     */
    public function getTablesNames()
    {
        return [
            'acl_users',
            'acl_roles',
            'acl_role_user',
            'acl_permissions',
            'acl_permission_role',
            'acl_permission_user',
        ];
    }

    /**
     * Get the migrations source path.
     *
     * @return string
     */
    protected function getMigrationsSrcPath()
    {
        return realpath(dirname(__DIR__) . '/src/migrations/acl');
    }

    /**
     * Get the migrations destination path.
     *
     * @return string
     */
    protected function getMigrationsDestPath()
    {
        return realpath(database_path('migrations'));
    }

    /**
     * Migrate the migrations.
     */
    protected function migrate()
    {
        $this->artisan('migrate', [
            '--database' => 'testing',
            '--realpath' => $this->getMigrationsSrcPath(),
        ]);
    }

    /**
     * Reset all migrations.
     */
    protected function resetMigration()
    {
        $this->artisan('migrate:reset');
    }

    /**
     * Publish the migrations.
     */
    protected function publishMigrations()
    {
        $this->artisan('vendor:publish', [
            '--tag' => ['migrations'],
        ]);
    }
}

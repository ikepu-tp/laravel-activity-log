<?php

namespace ikepu_tp\ActivityLog;

use ErrorException;
use ikepu_tp\ActivityLog\app\Console\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/activity-log.php', 'activity-log');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPublishing();
        //$this->defineRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . "/resources/views", "ActivityLog");
        Paginator::useBootstrap();
        Blade::componentNamespace("ikepu_tp\\resources\\views\\components", "ActivityLog");
        if (!$this->app->runningInConsole()) return;
        $this->commands([
            InstallCommand::class,
        ]);
    }

    /**
     * Register the package's publishable resources.
     */
    private function registerPublishing()
    {
        if (!$this->app->runningInConsole()) return;

        $this->publishes([
            __DIR__ . '/config/activity-log.php' => base_path('config/activity-log.php'),
        ], 'ActivityLog-config');


        $this->publishMigration();
        //$this->publishView();
        //$this->publishAsset();
    }

    private function publishMigration(): void
    {
        $migrations = [
            "2023_08_21_005426_create_activity_logs_table.php"
        ];
        foreach ($migrations as $migration) {
            $this->publishes([
                __DIR__ . "/database/migrations/{$migration}" => database_path(
                    "migrations/{$migration}"
                ),
            ], 'migrations');
        }
    }

    private function publishView(): void
    {
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/ActivityLog'),
        ], 'ActivityLog-views');
    }

    private function publishAsset(): void
    {
        $this->publishes([], 'ActivityLog-assets');
    }

    /**
     * Define the routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        try {
            $this->loadRoutesFrom(base_path("routes/activity-log.php"));
        } catch (ErrorException $e) {
            if (!file_exists(base_path("routes/activity-log.php"))) copy(__DIR__ . "/routes/web.php", base_path("routes/activity-log.php"));
            $this->loadRoutesFrom(base_path("routes/activity-log.php"));
        }
    }
}

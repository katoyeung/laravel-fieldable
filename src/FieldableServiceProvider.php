<?php

namespace Kato\Fieldable;

use Illuminate\Support\ServiceProvider;

class FieldableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerMigrations();
        $this->registerPublishing();
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/database/migrations' => database_path('migrations'),
            ], 'fieldable-migrations');
        }
    }
}

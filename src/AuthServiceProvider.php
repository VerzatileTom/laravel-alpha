<?php

namespace Fligno\Auth;

use Illuminate\Support\ServiceProvider;
use Fligno\Auth\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class AuthServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Auth');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Load factories
        $this->registerEloquentFactoriesFrom(__DIR__ . '/database/factories');

        $this->publishes([
            __DIR__ . '/resources/js' => public_path('/js'),
        ], 'auth');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}

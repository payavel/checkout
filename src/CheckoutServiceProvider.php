<?php

namespace Payavel\Checkout;

use Illuminate\Support\ServiceProvider;
use Payavel\Checkout\Console\Commands\CheckoutInstall;
use Payavel\Checkout\Console\Commands\CheckoutProvider;

class CheckoutServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->registerPublishableAssets();

        $this->registerCommands();

        $this->registerMigrations();
    }

    public function register()
    {
        $this->app->singleton(CheckoutGateway::class, function ($app) {
            return new CheckoutGateway();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/checkout.php',
            'checkout'
        );
    }

    protected function registerPublishableAssets()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/2024_01_01_000010_create_base_checkout_tables.php' => database_path('migrations/2024_01_01_000010_create_base_checkout_tables.php'),
        ], ['payavel', 'payavel-checkout', 'payavel-migrations']);
    }

    protected function registerCommands()
    {
        $this->commands([
            CheckoutInstall::class,
            CheckoutProvider::class,
        ]);
    }

    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}

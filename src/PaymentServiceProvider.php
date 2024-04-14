<?php

namespace Payavel\Checkout;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Payavel\Checkout\Console\Commands\CheckoutInstall;
use Payavel\Checkout\Console\Commands\CheckoutProvider;
use Payavel\Orchestration\Service;

class PaymentServiceProvider extends ServiceProvider
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
        $this->app->singleton(PaymentGateway::class, function ($app) {
            return new PaymentGateway();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/payment.php',
            'payment'
        );
    }

    protected function registerPublishableAssets()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/2021_01_01_000000_create_base_payment_tables.php' => database_path('migrations/2021_01_01_000000_create_base_payment_tables.php'),
        ], 'payavel-migrations');

        $this->publishes([
            __DIR__ . '/stubs/config-publish.stub' => config_path('payment.php'),
        ], 'payavel-config');
    }

    protected function registerCommands()
    {
        $this->commands([
            CheckoutProvider::class,
            CheckoutInstall::class,
        ]);
    }

    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}

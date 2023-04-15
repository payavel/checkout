<?php

namespace Payavel\Checkout;

use Illuminate\Support\ServiceProvider;
use Payavel\Checkout\Console\Commands\Install;
use Payavel\Checkout\Console\Commands\MakeProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPublishableAssets();

        $this->registerCommands();
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
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/database/migrations/2021_01_01_000000_create_base_payment_tables.php' => database_path('migrations/2021_01_01_000000_create_base_payment_tables.php'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/stubs/config-publish.stub' => config_path('payment.php'),
        ], 'config');
    }

    protected function registerCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            MakeProvider::class,
            Install::class,
        ]);
    }
}

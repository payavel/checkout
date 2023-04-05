<?php

namespace Payavel\Checkout;

use Illuminate\Support\ServiceProvider;
use Payavel\Checkout\Console\Commands\Install;
use Payavel\Checkout\Console\Commands\MakeProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->vendorPublish();
            $this->commands([
                MakeProvider::class,
                Install::class,
            ]);
        }
    }

    protected function vendorPublish()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/2021_01_01_000000_create_base_payment_tables.php' => database_path('migrations/' . now()->format('Y_m_d_His') . '_create_base_payment_tables.php'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/stubs/config-publish.stub' => config_path('payment.php'),
        ], 'config');
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
}

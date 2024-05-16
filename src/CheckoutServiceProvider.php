<?php

namespace Payavel\Checkout;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Payavel\Checkout\Console\Commands\CheckoutInstall;
use Payavel\Checkout\Console\Commands\CheckoutProvider;
use Payavel\Checkout\Models\Dispute;
use Payavel\Checkout\Models\Payment;
use Payavel\Checkout\Models\Refund;
use Payavel\Orchestration\Support\ServiceConfig;

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

        Relation::morphMap([
            Payment::class => fn () => ServiceConfig::get('checkout', 'models.' . Payment::class, Payment::class),
            Refund::class => fn () => ServiceConfig::get('checkout', 'models.' . Refund::class, Refund::class),
            Dispute::class => fn () => ServiceConfig::get('checkout', 'models.' . Dispute::class, Dispute::class),
        ]);
    }

    public function register()
    {
        $this->app->singleton(
            CheckoutGateway::class,
            fn ($app) => new CheckoutGateway()
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/checkout.php',
            'checkout'
        );
    }

    protected function registerPublishableAssets()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/2024_01_01_000010_create_base_checkout_tables.php' => database_path('migrations/2024_01_01_000010_create_base_checkout_tables.php'),
        ], ['payavel', 'payavel-checkout', 'payavel-migrations', 'payavel-checkout-migrations']);

        $this->publishes([
            __DIR__ . '/../stubs/config-service.stub' => base_path('stubs/orchestration/checkout/config-service.stub'),
            __DIR__ . '/../stubs/config-service-database.stub' => base_path('stubs/orchestration/checkout/config-service-database.stub'),
            __DIR__ . '/../stubs/service-requester.stub' => base_path('stubs/orchestration/checkout/service-requester.stub'),
            __DIR__ . '/../stubs/service-responder.stub' => base_path('stubs/orchestration/checkout/service-responder.stub'),
            __DIR__ . '/../stubs/service-request.stub' => base_path('stubs/orchestration/checkout/service-request.stub'),
            __DIR__ . '/../stubs/service-response.stub' => base_path('stubs/orchestration/checkout/service-response.stub'),
        ], ['payavel', 'payavel-checkout', 'payavel-stubs', 'payavel-checkout-stubs']);
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

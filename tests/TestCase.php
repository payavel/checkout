<?php

namespace Payavel\Checkout\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Payavel\Checkout\PaymentServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase, WithFaker;

    protected function getPackageProviders($app)
    {
        return [
            PaymentServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'payments_test');
        $app['config']->set('database.connections.payments_test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    /**
     * Perform any work that should take place once the database has finished refreshing.
     *
     * @return void
     */
    protected function afterRefreshingDatabase()
    {
        if (! class_exists('CreateBasePaymentTables')) {
            $this->artisan('vendor:publish', ['--provider' => 'Payavel\Checkout\PaymentServiceProvider', '--tag' => 'payavel-migrations']);

            $this->artisan('migrate');
        }
    }
}

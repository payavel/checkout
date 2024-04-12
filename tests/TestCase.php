<?php

namespace Payavel\Checkout\Tests;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\PaymentServiceProvider;
use Payavel\Checkout\Traits\Billable as BillableTrait;
use Payavel\Orchestration\Contracts\Serviceable;
use Payavel\Orchestration\OrchestrationServiceProvider;
use Payavel\Orchestration\Tests\Traits\CreatesServices;

class TestCase extends \Payavel\Orchestration\Tests\TestCase
{
    use CreatesServices;

    protected Serviceable $checkoutService;

    protected function getPackageProviders($app)
    {
        return [
            OrchestrationServiceProvider::class,
            PaymentServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'checkout_test');
        $app['config']->set('database.connections.checkout_test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutService = $this->createService([
            'name' => 'Checkout',
            'id' => 'checkout',
        ]);
    }
}

class User extends \Payavel\Orchestration\Tests\User implements Billable
{
    use BillableTrait;
}

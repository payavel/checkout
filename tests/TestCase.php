<?php

namespace Payavel\Checkout\Tests;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\CheckoutServiceProvider;
use Payavel\Checkout\Traits\Billable as BillableTrait;
use Payavel\Orchestration\Fluent\ServiceConfig;
use Payavel\Orchestration\OrchestrationServiceProvider;
use Payavel\Orchestration\Tests\Traits\CreatesServices;

class TestCase extends \Payavel\Orchestration\Tests\TestCase
{
    use CreatesServices;

    protected ServiceConfig $checkoutService;

    protected function getPackageProviders($app)
    {
        return [
            OrchestrationServiceProvider::class,
            CheckoutServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'checkout_test');
        $app['config']->set('database.connections.checkout_test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $app['config']->set('orchestration.services.checkout', 'checkout');
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->checkoutService = $this->createServiceConfig([
            'name' => 'Checkout',
            'id' => 'checkout',
        ]);
    }
}

class User extends \Payavel\Orchestration\Tests\User implements Billable
{
    use BillableTrait;

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}

class UserFactory extends \Payavel\Orchestration\Tests\UserFactory
{
    protected $model = User::class;
}

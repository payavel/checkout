<?php

namespace Payavel\Checkout\Tests;

use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\CheckoutServiceProvider;
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

    // ToDo: Move this into the orchestration package.
    protected function tearDown(): void
    {
        if (file_exists($migration = database_path('migrations/2024_01_01_000001_create_base_orchestration_tables.php'))) {
            unlink($migration);
        }

        parent::tearDown();
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

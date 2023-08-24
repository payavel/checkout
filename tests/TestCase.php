<?php

namespace Payavel\Checkout\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Payavel\Checkout\Contracts\Billable;
use Payavel\Checkout\PaymentServiceProvider;
use Payavel\Checkout\Traits\Billable as BillableTrait;
use Payavel\Serviceable\ServiceableServiceProvider;
use Payavel\Serviceable\Tests\Traits\CreateServiceables;
use Payavel\Serviceable\Tests\Traits\SetUpDriver;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use CreateServiceables,
        RefreshDatabase,
        SetUpDriver,
        WithFaker;

    protected function getPackageProviders($app)
    {
        return [
            ServiceableServiceProvider::class,
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
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->afterApplicationRefreshedCallbacks = [
            function() {
                $this->setUpDriver();
            }
        ];

        parent::setUp();

        $this->createService(['id' => 'checkout', 'name' => 'Checkout']);

        Schema::create('users', function ($table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
}

class User extends Model implements Billable
{
    use BillableTrait,
        HasFactory;

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
        ];
    }
}

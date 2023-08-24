<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

use Payavel\Checkout\Tests\TestCase;
use Payavel\Serviceable\Service;
use Payavel\Serviceable\Tests\Traits\AssertGatewayExists;
use Payavel\Serviceable\Tests\Traits\CreateServiceables;

class MakeProviderCommandTest extends TestCase
{
    use AssertGatewayExists,
        CreateServiceables;

    /** @test */
    public function make_provider_command_defaults_to_checkout_service()
    {
        $provider = $this->createProvider(Service::find('checkout'));

        $this->artisan('checkout:provider', [
            'provider' => $provider->getName(),
            '--id' => $provider->getId(),
        ])
            ->expectsOutput("{$provider->name} checkout gateway generated successfully!")
            ->assertExitCode(0);

        $this->assertGatewayExists($provider);
    }
}

<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Service;
use Payavel\Orchestration\Tests\Traits\AssertsGatewayExists;
use Payavel\Orchestration\Tests\Traits\CreatesServiceables;

class MakeProviderCommandTest extends TestCase
{
    use AssertsGatewayExists,
        CreatesServiceables;

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

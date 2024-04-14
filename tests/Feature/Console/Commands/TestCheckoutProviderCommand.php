<?php

namespace Payavel\Checkout\Tests\Feature\Console\Commands;

use Payavel\Checkout\Tests\TestCase;
use Payavel\Orchestration\Tests\Contracts\CreatesServiceables;
use Payavel\Orchestration\Tests\Traits\AssertsServiceExists;
use PHPUnit\Framework\Attributes\Test;

abstract class TestCheckoutProviderCommand extends TestCase implements CreatesServiceables
{
    use AssertsServiceExists;

    #[Test]
    public function checkout_provider_command_injects_checkout_service_into_orchestrate_provider_command()
    {
        $provider = $this->createProvider($this->checkoutService);

        $gateway = $this->gatewayPath($provider);

        $this->artisan('orchestrate:provider', [
            'provider' => $provider->getId(),
        ])
            ->expectsOutputToContain("Gateway [app/{$gateway->request}] created successfully.")
            ->expectsOutputToContain("Gateway [app/{$gateway->response}] created successfully.")
            ->assertSuccessful();

        $this->assertGatewayExists($provider);
    }
}

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
        $provider = $this->createProvider($this->checkoutConfig);

        $gateway = $this->gatewayPath($this->checkoutConfig, $provider);

        $ds = DIRECTORY_SEPARATOR;
        $this->artisan('checkout:provider', [
            'provider' => $provider->getName(),
            '--id' => $provider->getId(),
        ])
            ->expectsOutputToContain("Gateway [app{$ds}{$gateway->request}] created successfully.")
            ->expectsOutputToContain("Gateway [app{$ds}{$gateway->response}] created successfully.")
            ->assertSuccessful();

        $this->assertGatewayExists($this->checkoutConfig, $provider);
    }
}
